@extends('layouts.default')

@section('main-page')

<style>
body{
    background:#f3f4f6;
}

/* TOP BAR */
.top-summary{
    background:#111827;
    color:#fff;
    padding:15px;
    text-align:center;
    font-weight:600;
    border-radius:8px;
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
    background:#fff;
}

th{
    background:#7c0a02;
    color:#fff;
    padding:12px;
}

td{
    padding:10px;
    text-align:center;
    border:1px solid #eee;
}

.category-title td{
    background:#b91c1c;
    color:#fff;
    font-weight:bold;
}

.qty{
    width:70px;
    padding:5px;
}

/* BUTTON */
.confirm-btn{
    margin:30px 0;
    text-align:center;
}

.confirm-btn button{
    background:#dc2626;
    color:#fff;
    padding:12px 40px;
    border:none;
    border-radius:30px;
    font-size:18px;
}

/* OVERLAY */
.overlay{
    position:fixed;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.6);
    top:0;
    left:0;
    display:none;
    z-index:999;
}

/* PANEL */
.panel{
    position:fixed;
    right:-450px;
    top:0;
    width:430px;
    height:100%;
    background:#fff;
    transition:0.4s;
    z-index:1000;
    overflow-y:auto;
}

.panel-header{
    background:#7c0a02;
    color:#fff;
    padding:15px;
    display:flex;
    justify-content:space-between;
}

.panel-body{
    padding:20px;
}

.product-line{
    display:flex;
    justify-content:space-between;
    font-size:14px;
    margin-bottom:6px;
}

.total-box{
    margin-top:15px;
    border-top:1px solid #ddd;
    padding-top:10px;
}

.total-box p{
    display:flex;
    justify-content:space-between;
    margin:6px 0;
}

input,select,textarea{
    width:100%;
    padding:8px;
    margin:6px 0;
    border:1px solid #ccc;
    border-radius:5px;
}

.submit-btn{
    width:100%;
    background:#16a34a;
    color:#fff;
    padding:10px;
    border:none;
    margin-top:10px;
}
</style>

<div class="container">

    <div class="top-summary">
        Net Total ₹ <span id="netTotal">0</span> |
        You Save ₹ <span id="youSave">0</span>
    </div>

    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Actual</th>
                <th>Offer</th>
                <th>Qty</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>

            <tr class="category-title">
                <td colspan="5">ONE SOUND CRACKERS (50% DISCOUNT)</td>
            </tr>

            <tr>
                <td>4' Lakshmi</td>
                <td class="actual">30</td>
                <td class="price">15</td>
                <td><input type="number" class="qty" value="0"></td>
                <td class="rowTotal">0</td>
            </tr>

            <tr>
                <td>3 1/2 Lakshmi</td>
                <td class="actual">24</td>
                <td class="price">12</td>
                <td><input type="number" class="qty" value="0"></td>
                <td class="rowTotal">0</td>
            </tr>

        </tbody>
    </table>

    <div class="confirm-btn">
        <button onclick="openPanel()">CONFIRM ESTIMATE</button>
    </div>

</div>

<!-- Overlay -->
<div id="overlay" class="overlay" onclick="closePanel()"></div>

<!-- Checkout Panel -->
<div id="panel" class="panel">

    <div class="panel-header">
        <h4>Order Summary</h4>
        <span onclick="closePanel()" style="cursor:pointer;">✖</span>
    </div>

    <div class="panel-body">

        <!-- Selected Products -->
        <div id="selectedProducts"></div>

        <div class="total-box">
            <p>Sub Total <span>₹ <span id="subTotal">0</span></span></p>
            <p>You Save <span>₹ <span id="saveTotal">0</span></span></p>
            <p>Packing Charges <span>₹ 0</span></p>
            <p>Round Off <span>₹ 0.00</span></p>
            <hr>
            <p><b>Overall</b> <b>₹ <span id="finalTotal">0</span></b></p>
        </div>

        <hr>

        <h5>Customer Details</h5>

        <select id="stateSelect" onchange="checkMin()">
            <option value="">Select State</option>
            <option value="Tamil Nadu">Tamil Nadu</option>
            <option value="Telangana">Telangana</option>
            <option value="Karnataka">Karnataka</option>
            <option value="Maharashtra">Maharashtra</option>
            <option value="Andhra Pradesh">Andhra Pradesh</option>
            <option value="Kerala">Kerala</option>
        </select>

        <p style="color:red;">Min Amount: ₹ <span id="minAmount">0</span></p>

        <input type="text" placeholder="Name">
        <input type="text" placeholder="Mobile">
        <input type="email" placeholder="Email">
        <textarea placeholder="Address"></textarea>

        <button class="submit-btn">Submit Order</button>

    </div>

</div>

<script>

document.querySelectorAll('.qty').forEach(q=>{
    q.addEventListener('input',calculate);
});

function calculate(){

    let net=0;
    let actual=0;

    document.querySelectorAll('tbody tr').forEach(row=>{

        if(row.querySelector('.qty')){

            let qty=parseInt(row.querySelector('.qty').value)||0;
            let price=parseFloat(row.querySelector('.price').innerText);
            let act=parseFloat(row.querySelector('.actual').innerText);

            let total=qty*price;
            row.querySelector('.rowTotal').innerText=total;

            net+=total;
            actual+=qty*act;
        }
    });

    document.getElementById('netTotal').innerText=net;
    document.getElementById('youSave').innerText=actual-net;
}

function openPanel(){

    let net=document.getElementById('netTotal').innerText;
    if(net==0){
        alert("Add products first");
        return;
    }

    let productHTML="";
    document.querySelectorAll('tbody tr').forEach(row=>{
        let qty=parseInt(row.querySelector('.qty')?.value)||0;
        if(qty>0){
            let name=row.children[0].innerText;
            let total=row.querySelector('.rowTotal').innerText;
            productHTML+=`<div class="product-line">
                            <span>${name} x ${qty}</span>
                            <span>₹ ${total}</span>
                          </div>`;
        }
    });

    document.getElementById('selectedProducts').innerHTML=productHTML;
    document.getElementById('subTotal').innerText=net;
    document.getElementById('saveTotal').innerText=document.getElementById('youSave').innerText;
    document.getElementById('finalTotal').innerText=net;

    document.getElementById('panel').style.right="0";
    document.getElementById('overlay').style.display="block";
}

function closePanel(){
    document.getElementById('panel').style.right="-450px";
    document.getElementById('overlay').style.display="none";
}

function checkMin(){

    let state=document.getElementById('stateSelect').value;
    let min=0;

    if(state=="Tamil Nadu"){
        min=2500;
    }else{
        min=5000;
    }

    document.getElementById('minAmount').innerText=min;

    let total=parseInt(document.getElementById('finalTotal').innerText);

    if(total < min){
        alert("Minimum order for "+state+" is ₹"+min);
    }
}

</script>

@endsection



@extends('layouts.default')

@section('main-page')

<style>

/* ===== PAGE BACKGROUND ===== */
body{
    background:#f4f6f9;
}

/* ===== TOP SUMMARY ===== */
.top-summary{
    background:#111827;
    color:#fff;
    padding:15px;
    text-align:center;
    font-weight:600;
    border-radius:8px;
}

.top-summary span{
    color:#ffd700;
    font-weight:bold;
}

/* ===== TABLE ===== */
table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
    background:#fff;
    box-shadow:0 5px 20px rgba(0,0,0,0.05);
}

th{
    background:#b91c1c;
    color:#fff;
    padding:12px;
}

td{
    padding:10px;
    text-align:center;
    border-bottom:1px solid #eee;
}

.category-title td{
    background:#1f2937;
    color:#fff;
    font-weight:bold;
}

.qty{
    width:60px;
    padding:5px;
    border-radius:5px;
    border:1px solid #ccc;
}

/* ===== BUTTON ===== */
.bottom-btn{
    text-align:center;
    margin:30px 0;
}

.bottom-btn button{
    background:#dc2626;
    color:#fff;
    padding:14px 40px;
    border:none;
    font-size:18px;
    border-radius:30px;
    cursor:pointer;
    box-shadow:0 8px 20px rgba(0,0,0,0.2);
}

/* ===== CART ICON ===== */
.cart-box{
    position:fixed;
    right:40px;
    top:180px;
    font-size:26px;
}

.cart-box span{
    position:absolute;
    top:-8px;
    right:-10px;
    background:#ffd700;
    border-radius:50%;
    width:22px;
    height:22px;
    font-size:13px;
    font-weight:bold;
}

/* ===== OVERLAY ===== */
.overlay-bg{
    position:fixed;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.6);
    top:0;
    left:0;
    display:none;
    z-index:999;
}

/* ===== CHECKOUT PANEL ===== */
.checkout-panel{
    position:fixed;
    right:-420px;
    top:0;
    width:400px;
    height:100%;
    background:#fff;
    box-shadow:-5px 0 15px rgba(0,0,0,0.2);
    transition:0.4s;
    z-index:1000;
    display:flex;
    flex-direction:column;
}

.checkout-header{
    background:#b91c1c;
    color:#fff;
    padding:15px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.checkout-body{
    padding:20px;
    overflow-y:auto;
}

.summary-box p{
    display:flex;
    justify-content:space-between;
    margin:8px 0;
}

.summary-box .final{
    font-weight:bold;
    font-size:18px;
}

.checkout-body input,
.checkout-body textarea{
    width:100%;
    padding:10px;
    margin:8px 0;
    border-radius:6px;
    border:1px solid #ccc;
}

.submit-btn{
    width:100%;
    padding:12px;
    background:#16a34a;
    color:#fff;
    border:none;
    border-radius:6px;
    font-size:16px;
}

</style>

<div class="container mt-4">

    <div class="top-summary">
        Net Total : ₹ <span id="netTotal">0</span> |
        You Save : ₹ <span id="youSave">0</span> |
        Overall Total : ₹ <span id="overallTotal">0</span>
    </div>

    <div class="cart-box">
        🛒 <span id="cartCount">0</span>
    </div>

    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Actual</th>
                <th>Offer</th>
                <th>Qty</th>
                <th>Total</th>
            </tr>
        </thead>

        <tbody>

        <tr class="category-title">
            <td colspan="5">ONE SOUND CRACKERS (50% OFF)</td>
        </tr>

        <tr>
            <td>4' Lakshmi</td>
            <td class="actual">30</td>
            <td class="price">15</td>
            <td><input type="number" class="qty" value="0"></td>
            <td class="rowTotal">0</td>
        </tr>

        <tr>
            <td>Red Bijili</td>
            <td class="actual">70</td>
            <td class="price">35</td>
            <td><input type="number" class="qty" value="0"></td>
            <td class="rowTotal">0</td>
        </tr>

        </tbody>
    </table>

    <div class="bottom-btn">
        <button onclick="openCheckout()">CONFIRM ESTIMATE</button>
    </div>

</div>

<!-- Overlay -->
<div id="overlay" class="overlay-bg" onclick="closeCheckout()"></div>

<!-- Checkout Panel -->
<div id="checkoutPanel" class="checkout-panel">

    <div class="checkout-header">
        <h4>Sri Balaji Crackers</h4>
        <span onclick="closeCheckout()" style="cursor:pointer;">✖</span>
    </div>

    <div class="checkout-body">

        <div class="summary-box">
            <p>Net Total <span>₹ <span id="cNet">0</span></span></p>
            <p>You Save <span>₹ <span id="cSave">0</span></span></p>
            <hr>
            <p class="final">Overall <span>₹ <span id="cTotal">0</span></span></p>
        </div>

        <h5>Customer Details</h5>

        <input type="text" placeholder="Full Name">
        <input type="text" placeholder="Mobile Number">
        <input type="email" placeholder="Email">
        <textarea placeholder="Address"></textarea>

        <button class="submit-btn">Submit Order</button>

    </div>

</div>

<script>

document.querySelectorAll('.qty').forEach(input=>{
    input.addEventListener('input',calculate);
});

function calculate(){

    let netTotal=0;
    let actualTotal=0;
    let cartItems=0;

    document.querySelectorAll('tbody tr').forEach(row=>{

        if(row.querySelector('.qty')){

            let qty=parseInt(row.querySelector('.qty').value)||0;
            let price=parseFloat(row.querySelector('.price').innerText);
            let actual=parseFloat(row.querySelector('.actual').innerText);

            let total=qty*price;
            let actualRow=qty*actual;

            row.querySelector('.rowTotal').innerText=total;

            netTotal+=total;
            actualTotal+=actualRow;

            if(qty>0) cartItems++;
        }

    });

    document.getElementById('netTotal').innerText=netTotal;
    document.getElementById('overallTotal').innerText=netTotal;
    document.getElementById('youSave').innerText=actualTotal-netTotal;
    document.getElementById('cartCount').innerText=cartItems;

}

function openCheckout(){
    document.getElementById("checkoutPanel").style.right="0";
    document.getElementById("overlay").style.display="block";

    document.getElementById("cNet").innerText=
        document.getElementById("netTotal").innerText;

    document.getElementById("cSave").innerText=
        document.getElementById("youSave").innerText;

    document.getElementById("cTotal").innerText=
        document.getElementById("overallTotal").innerText;
}

function closeCheckout(){
    document.getElementById("checkoutPanel").style.right="-420px";
    document.getElementById("overlay").style.display="none";
}

</script>

@endsection
