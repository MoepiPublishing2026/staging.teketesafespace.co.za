// <?php

// namespace App\Http\Controllers;

// use App\Models\Subscription;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Log;
// use Illuminate\Support\Str;
// use Carbon\Carbon;

// class SubscriptionController extends Controller
// {
//     // ── Plans config ──────────────────────────────────────────────────────────
//     private array $plans = [
//         'starter' => ['name' => 'Starter (Free)', 'amount' => 0,    'months' => null],
//         'monthly' => ['name' => 'Monthly Pro',     'amount' => 450,  'months' => 1],
//         'annual'  => ['name' => 'Annual Pro',      'amount' => 5000, 'months' => 12],
//     ];

//     // ── 1. Subscribe page ─────────────────────────────────────────────────────
//     public function index()
//     {
//         $user         = Auth::user();
//         $subscription = $user->subscription;

//         return view('admin.subscribe', compact('user', 'subscription'));
//     }

//     // ── 2. Checkout ───────────────────────────────────────────────────────────
//     public function checkout(string $plan)
//     {
//         if (!array_key_exists($plan, $this->plans)) {
//             return redirect()->route('admin.subscribe')->with('error', 'Invalid plan selected.');
//         }

//         $user    = Auth::user();
//         $details = $this->plans[$plan];

//         // Free / Starter — activate directly, no PayFast
//         if ($details['amount'] === 0) {
//             Subscription::updateOrCreate(
//                 ['user_id' => $user->id],
//                 [
//                     'plan'        => 'starter',
//                     'status'      => 'free',
//                     'starts_at'   => Carbon::now(),
//                     'expires_at'  => null,
//                     'amount_paid' => 0,
//                 ]
//             );

//             $user->update(['is_subscribed' => true]);

//             return redirect()->route('admin.dashboard')
//                 ->with('success', 'You are now on the free Starter plan.');
//         }

//         // Paid plan — generate unique reference and store pending record
//         $mPaymentId = 'TEKE-' . strtoupper(Str::random(8)) . '-' . time();

//         Subscription::updateOrCreate(
//             ['user_id' => $user->id],
//             [
//                 'plan'         => $plan,
//                 'status'       => 'pending',
//                 'm_payment_id' => $mPaymentId,
//                 'amount_paid'  => $details['amount'],
//                 'starts_at'    => null,
//                 'expires_at'   => null,
//             ]
//         );

//         $nameParts = explode(' ', trim($user->name));

//         $data = [
//             'merchant_id'   => config('services.payfast.merchant_id'),
//             'merchant_key'  => config('services.payfast.merchant_key'),
//             'return_url'    => route('payment.success'),
//             'cancel_url'    => route('admin.subscribe'),
//             'notify_url'    => route('payment.notify'),
//             'name_first'    => $nameParts[0],
//             'name_last'     => $nameParts[1] ?? '',
//             'email_address' => $user->email,
//             'm_payment_id'  => $mPaymentId,
//             'amount'        => number_format($details['amount'], 2, '.', ''),
//             'item_name'     => 'Tekete Safe Space — ' . $details['name'],
//         ];

//         $data['signature'] = $this->generateSignature($data);

//         $payfastUrl = config('services.payfast.sandbox')
//             ? 'https://sandbox.payfast.co.za/eng/process'
//             : 'https://www.payfast.co.za/eng/process';

//         return view('admin.payfast_redirect', compact('data', 'payfastUrl'));
//     }

//     // ── 3. PayFast ITN — server-to-server payment notification ───────────────
//     public function notify(Request $request)
//     {
//         $data = $request->all();

//         // Step 1 — Verify signature
//         $receivedSignature = $data['signature'] ?? '';
//         unset($data['signature']);

//         if ($receivedSignature !== $this->generateSignature($data)) {
//             Log::warning('PayFast ITN: Invalid signature', $data);
//             return response('Invalid signature', 400);
//         }

//         // Step 2 — Verify request is from a PayFast server
//         $validHosts = [
//             'www.payfast.co.za',
//             'sandbox.payfast.co.za',
//             'w1w.payfast.co.za',
//             'w2w.payfast.co.za',
//         ];
//         $remoteHost = gethostbyaddr($request->server('REMOTE_ADDR', ''));
//         if (!in_array($remoteHost, $validHosts)) {
//             Log::warning('PayFast ITN: Untrusted host', ['host' => $remoteHost]);
//             return response('Untrusted host', 400);
//         }

//         // Step 3 — Find subscription by our payment reference
//         $mPaymentId    = $data['m_payment_id']   ?? null;
//         $paymentStatus = $data['payment_status']  ?? null;
//         $amountGross   = (float) ($data['amount_gross'] ?? 0);

//         $subscription = Subscription::where('m_payment_id', $mPaymentId)->first();

//         if (!$subscription) {
//             Log::warning('PayFast ITN: Subscription not found', ['m_payment_id' => $mPaymentId]);
//             return response('Subscription not found', 404);
//         }

//         // Step 4 — Verify amount matches
//         if ($amountGross !== (float) number_format($subscription->amount_paid, 2, '.', '')) {
//             Log::warning('PayFast ITN: Amount mismatch', [
//                 'expected' => $subscription->amount_paid,
//                 'received' => $amountGross,
//             ]);
//             return response('Amount mismatch', 400);
//         }

//         // Step 5 — Update subscription based on payment status
//         if ($paymentStatus === 'COMPLETE') {
//             $months    = $this->plans[$subscription->plan]['months'] ?? 1;
//             $expiresAt = Carbon::now()->addMonths($months);

//             $subscription->update([
//                 'status'        => 'active',
//                 'payfast_token' => $data['pf_payment_id'] ?? null,
//                 'starts_at'     => Carbon::now(),
//                 'expires_at'    => $expiresAt,
//             ]);

//             $subscription->user->update(['is_subscribed' => true]);

//             Log::info('PayFast ITN: Subscription activated', [
//                 'user_id'    => $subscription->user_id,
//                 'plan'       => $subscription->plan,
//                 'expires_at' => $expiresAt,
//             ]);

//         } elseif (in_array($paymentStatus, ['FAILED', 'CANCELLED'])) {
//             $subscription->update(['status' => 'cancelled']);
//             $subscription->user->update(['is_subscribed' => false]);

//             Log::info('PayFast ITN: Payment failed/cancelled', [
//                 'user_id' => $subscription->user_id,
//                 'status'  => $paymentStatus,
//             ]);
//         }

//         // PayFast requires a 200 OK response
//         return response('OK', 200);
//     }

//     // ── Signature generator ───────────────────────────────────────────────────
//     private function generateSignature(array $data): string
//     {
//         $data = array_filter($data, fn($v) => $v !== '' && $v !== null);

//         $pfOutput = '';
//         foreach ($data as $key => $val) {
//             $pfOutput .= $key . '=' . urlencode(trim((string) $val)) . '&';
//         }

//         $pfOutput = rtrim($pfOutput, '&');

//         $passphrase = config('services.payfast.passphrase');
//         if (!empty($passphrase)) {
//             $pfOutput .= '&passphrase=' . urlencode(trim($passphrase));
//         }

//         return md5($pfOutput);
//     }
// }