<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h1 class="text-2xl font-bold mb-4 text-center text-gray-800">Report an Incident</h1>
        <p class="mb-6 text-center text-gray-500">Please provide the details of the incident below.</p>

        @if (session()->has('success_message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-md relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success_message') }}</span>
            </div>
        @endif

        <form wire:submit="submitReport" class="space-y-6">
            <div>
                <label for="abuseType" class="block text-sm font-medium text-gray-700 mb-1">Main Abuse Type</label>
                <select wire:model.live="abuseTypeID" id="abuseType" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <option value="">-- Select an Abuse Type --</option>
                    @foreach ($this->abuseTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->type_name }}</option>
                    @endforeach
                </select>
                @error('abuseTypeID') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            @if ($abuseTypeID)
                <div>
                    <label for="subtype" class="block text-sm font-medium text-gray-700 mb-1">Sub-Type</label>
                    <select wire:model.live="abuseSubID" id="subtype" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <option value="">-- Select a Subtype --</option>
                        @foreach ($this->subtypes as $subtype)
                            <option value="{{ $subtype->id }}">{{ $subtype->sub_type_name }}</option>
                        @endforeach
                    </select>
                    @error('abuseSubID') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>
            @endif

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea wire:model="description" id="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" placeholder="Please provide a detailed description of the incident."></textarea>
                @error('description') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="reporterEmail" class="block text-sm font-medium text-gray-700 mb-1">Your Email</label>
                <input type="email" id="reporterEmail" wire:model="reporterEmail" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" placeholder="e.g., jane.doe@example.com">
                @error('reporterEmail') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="phoneNumber" class="block text-sm font-medium text-gray-700 mb-1">Phone Number (Optional)</label>
                <input type="text" id="phoneNumber" wire:model="phoneNumber" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" placeholder="e.g., 27712345678">
                @error('phoneNumber') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Submit Report
            </button>
        </form>
    </div>
</div>
