<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Payment</title>

<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;900&display=swap" rel="stylesheet">

<style>
:root {
    --green: #c7da30;
    --blue: #38b6ff;
    --text: #545454;
    --light-bg: #f3f5f4;
}

body {
    margin: 0;
    font-family: 'Montserrat', sans-serif;
    background: var(--light-bg);
    color: var(--text);
}

/* MAIN BOX */
.payment-wrapper {
    max-width: 1000px;
    margin: 60px auto;
    padding: 50px 80px;
    border: 4px solid var(--green);
    border-radius: 20px;
    background: white;
}

h2 {
    text-align: center;
    font-weight: 800;
    margin-bottom: 40px;
}

/* PAYMENT METHODS */
.methods {
    border: 2px solid var(--green);
    padding: 30px;
    display: flex;
    justify-content: space-around;
    align-items: center;
    margin-bottom: 50px;
}

.methods label {
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
}

/* INPUT ROWS */
.row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 30px;
}

.row input {
    border: none;
    border-bottom: 3px solid var(--green);
    outline: none;
    padding: 8px;
    width: 45%;
    font-size: 14px;
}

.small-row {
    display: flex;
    gap: 30px;
    margin-bottom: 40px;
}

.small-row input {
    border: none;
    border-bottom: 3px solid var(--green);
    outline: none;
    padding: 8px;
    width: 120px;
}

/* TOTALS */
.totals {
    margin-top: 40px;
    width: 300px;
    margin-left: auto;
}

.totals div {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
}

/* BUTTON */
.confirm-btn {
    display: block;
    margin: 50px auto 0 auto;
    padding: 14px 40px;
    border-radius: 30px;
    border: 3px solid var(--green);
    background: transparent;
    font-weight: 700;
    color: var(--blue);
    cursor: pointer;
}

.confirm-btn:hover {
    background: var(--green);
    color: black;
}
</style>
</head>

<body>

<div class="payment-wrapper">

    <h2>Payment Methods</h2>

    <div class="methods">
        <label>
            <input type="radio" name="method">
            Mastercard
        </label>

        <label>
            <input type="radio" name="method">
            PayPal
        </label>

        <label>
            <input type="radio" name="method">
            Visa
        </label>
    </div>

    <div class="row">
        <input type="text" placeholder="Card Number *">
        <input type="text" placeholder="Card Holder *">
    </div>

    <div class="small-row">
        <input type="text" placeholder="Month">
        <input type="text" placeholder="Year">
        <input type="text" placeholder="CVC">
    </div>

    <div class="totals">
        <div>
            <span>Subtotal</span>
            <span>R5 000</span>
        </div>
        <div>
            <span>VAT</span>
            <span>R750</span>
        </div>
        <div>
            <strong>Grand Total</strong>
            <strong>R5 750</strong>
        </div>
    </div>

    <button class="confirm-btn">
        CONFIRM PAYMENT
    </button>

</div>

</body>
</html>