<div class="modal fade qr-modal" id="qrCodeModal" tabindex="-1" role="dialog" aria-labelledby="qrCodeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="qrCodeModalLabel">E-Receipt</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Store name and address -->
                <div class="text-center">
                    <h3>Lucky Star Grocery</h3>
                    <span>Lot 9 Block 6 Mercedez Home Subdivision,<br>San Miguel, Sto. Tomas Batangas</span>
                    <hr>
                    <!-- QR code -->
                    <div class="d-flex justify-content-center align-items-center">
                        <div id="pickup-qrcode"></div>
                    </div>
                    <!-- Hidden input to store the dynamic QR code value -->
                    <input type="text" name="pickup-qrcode" id="pickup-qrcode-value" disabled hidden>
                </div>
                <!-- Receipt details -->
                <hr>
                <p><b>Order:</b> #<span id="details-order-number"></span></p>
                <p><b>Date:</b> <span id="details-order-date"></span></p>
                <hr>
                <!-- List of purchased items -->
                <ul class="list-group" id="product-list">
                    <!-- Product items will be added here dynamically -->
                </ul>
                <!-- Total amount -->
                <hr>
                <h4 class="d-flex justify-content-between">Total: <span class="badge badge-primary">₱<span
                            id="details-total-cost"></span></span></h4>
                <hr>
                <h4 class="d-flex justify-content-between">Payment Option:
                    <span>
                        <i class="badge badge-pill" id="details-payment-status"></i>
                        <span id="details-payment-option"></span>
                    </span>
                </h4>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveAsImageBtn">Save as Image</button>
            </div>
        </div>
    </div>
</div>
