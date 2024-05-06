<div class="customer-details-popup">
    <div class="popup-content ">
       <h4>
          {{ $vendor->company_name }} (Vendor Id :{{ $vendor->id }})
       </h4>
       <button class="close-popup-btn" data-bs-dismiss="modal" aria-label="Close">
          <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
             <path d="M8.01562 0.984375L0.984375 8.01562M0.984375 0.984375L8.01562 8.01562" stroke="#18202B"
                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
       </button>
       <div class="container">
          <div class="parent-table">
             <div class="child-table">
                <div class="container">
                   <div class="row">
                      <div class="table-responsive table-sec mb-4">
                         <table class="table table-striped">
                            <thead>
                               <tr>
                                  <th>Check</th>
                                  <th>ID</th>
                                  <th style="text-align: center">Paper</th>
                                  <th style="text-align: center">Purchase Price</th>
                               </tr>
                            </thead>
                            <tbody>
                               <tr>
                                  <td><input type="checkbox" id="paper_id" name="paper_id" value=""></td>
                                  <td>1</td>
                                  <td style="text-align: center">Art Paper</td>
                                  <td style="text-align: center"><input type="text" id="purchase_price" name="purchase_price" value=""></td>
                               </tr>
                               <tr>
                                  <td><input type="checkbox" id="paper_id" name="paper_id" value=""></td>
                                  <td>2</td>
                                  <td style="text-align: center">Bond Paper</td>
                                  <td style="text-align: center"><input type="text" id="purchase_price" name="purchase_price" value=""></td>
                               </tr>
                               <tr>
                                  <td><input type="checkbox" id="paper_id" name="paper_id" value=""></td>
                                  <td>3</td>
                                  <td style="text-align: center">A4 Size Paper</td>
                                  <td style="text-align: center"><input type="text" id="purchase_price" name="purchase_price" value=""></td>
                               </tr>
                            </tbody>
                         </table>
                      </div>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>