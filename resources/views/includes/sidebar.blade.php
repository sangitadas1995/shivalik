<aside id="sidebar" class="sidebar break-point-lg has-bg-image">
  <div class="sidebar-layout">
    <div class="sidebar-header">
      <span style="
           text-transform: uppercase;
           font-size: 15px;
           letter-spacing: 3px;
           font-weight: bold;
           "><img src="{{ asset('images/logo1.png') }}" class="w-100" />
      </span>
    </div>
    <div class="sidebar-content">
      <div class="ul-box mb-3">
        <ul class="row">
          <li>
            <a href="{{ route('users.index') }}" class="{{ Route::is('users.index','users.add', 'users.edit') ? 'activeBox' : null }}">
              <span class="w-100"><img src="{{ asset('images/mi_user.png') }}" />
              <br />User Management</span>
            </a>
          </li>
          <li>
            <a href="{{ route('customers.index') }}" class="{{ Route::is('customers.index','customers.add', 'customers.edit') ? 'activeBox' : null }}">
            <span class="w-100"><img src="{{ asset('images/customer.png') }}" />
              <br />Customers</span>
            </a>
          </li>
          <li>
            <a href="{{ route('orders.index') }}" class="{{ Route::is('orders.index','orders.add', 'orders.view') ? 'activeBox' : null }}">
              <span class="w-100"><img src="{{ asset('images/order-approve-outline-sharp.png') }}" />
                <br />Order Management</span>
            </a>
          </li>
          <li>
            <a href="{{ route('inventory.warehouse.list') }}" class="{{ Route::is('inventory.index','inventory.warehouse.add','inventory.warehouse.list') ? 'activeBox' : null }}">
            <span class="w-100"><img src="{{ asset('images/ic_round-inventory.png') }}" />
            <br />Inventory Management</span></a>
          </li>
        </ul>
      </div>
      <nav class="menu open-current-submenu">
        <ul>
          <li
            class="menu-item sub-menu {{ Route::is('paper-vendor','printing-vendor','vendors.add','vendors.printing.edit','vendors.paper.edit') ? 'open active' : null }}">
            <a>
              <span class="menu-icon">
                <i class="ri-layout-3-fill"></i>
              </span>
              <span class="menu-title">Vendor Management</span>
            </a>
            <div class="sub-menu-list">
              <ul>
                <li class="menu-item {{ Route::is('vendors.add') ? 'active' : null }}">
                  <a href="{{ route('vendors.add') }}" class="">
                    <span class="menu-title">Add vendor</span>
                  </a>
                </li>
                <li class="menu-item {{ Route::is('printing-vendor','vendors.printing.edit') ? 'active' : null }}">
                  <a href="{{ route('printing-vendor') }}">
                    <span class="menu-title">Printing vendor</span>
                  </a>
                </li>
                <li class="menu-item {{ Route::is('paper-vendor','vendors.paper.edit') ? 'active' : null }}">
                  <a href="{{ route('paper-vendor') }}">
                    <span class="menu-title">Paper vendor</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
          <li class="menu-item {{ Route::is('papertype.index','papertype.add','papertype.edit') ? 'active' : null }}">
            <a href="{{ route('papertype.index') }}">
              <span class="menu-icon">
                <i class="ri-pie-chart-2-fill"></i>
              </span>
              <span class="menu-title">Paper Type</span>
            </a>
          </li>
          <!-- manna -->
          <!-- <li class="menu-item sub-menu">
                 <a>
                   <span class="menu-icon">
                     <svg width="28" height="29" viewBox="0 0 28 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                       <path
                         d="M8.16663 18.0904V15.7358H12.8333V18.0904H8.16663ZM25.6666 22.2109V17.5017L24.3016 18.8792C23.8683 18.4415 23.3536 18.0945 22.787 17.8581C22.2204 17.6217 21.6131 17.5006 21 17.5017C18.4216 17.5017 16.3333 19.6091 16.3333 22.2109C16.3333 24.8127 18.4216 26.92 21 26.92C22.96 26.92 24.64 25.7074 25.3283 23.9768H23.3333C22.9761 24.4562 22.4822 24.814 21.9179 25.0023C21.3536 25.1906 20.7458 25.2004 20.1758 25.0305C19.6058 24.8605 19.1008 24.5189 18.7285 24.0514C18.3563 23.5838 18.1344 23.0127 18.0927 22.4144C18.051 21.8161 18.1914 21.2192 18.4952 20.7037C18.799 20.1882 19.2516 19.7786 19.7924 19.5298C20.3332 19.281 20.9364 19.2049 21.5213 19.3117C22.1062 19.4184 22.6448 19.7029 23.065 20.1271L21 22.2109H25.6666ZM14.21 20.445C14.0816 21.0336 14 21.6222 14 22.2109C14 22.411 14 22.5994 14.035 22.7995H4.66663V14.5585C4.66663 13.9341 4.91246 13.3352 5.35004 12.8936C5.78763 12.452 6.38112 12.204 6.99996 12.204H8.16663V5.14026H19.8333V12.204H21C21.6188 12.204 22.2123 12.452 22.6499 12.8936C23.0875 13.3352 23.3333 13.9341 23.3333 14.5585H6.99996V20.445H14.21ZM10.5 12.204H17.5V7.49483H10.5V12.204Z"
                         fill="#BEC9D9" />
                     </svg>
                 
                   </span>
                   <span class="menu-title">Printing Plate Vendor</span>
                 </a>
                 <div class="sub-menu-list">
                   <ul>
                     <li class="menu-item">
                       <a href="#">
                         <span class="menu-title">Grid</span>
                       </a>
                     </li>
                   </ul>
                 </div>
                 </li>
                 <li class="menu-item sub-menu">
                 <a>
                   <span class="menu-icon">
                     <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                       <g clip-path="url(#clip0_268_82)">
                         <path
                           d="M13.6 1.7H17V14.45C17 15.1263 16.7313 15.7749 16.2531 16.2531C15.7749 16.7313 15.1263 17 14.45 17H2.55C1.8737 17 1.2251 16.7313 0.746878 16.2531C0.26866 15.7749 0 15.1263 0 14.45L0 0H13.6V1.7ZM13.6 3.4V14.45C13.6 14.6754 13.6896 14.8916 13.849 15.051C14.0084 15.2104 14.2246 15.3 14.45 15.3C14.6754 15.3 14.8916 15.2104 15.051 15.051C15.2104 14.8916 15.3 14.6754 15.3 14.45V3.4H13.6ZM1.7 1.7V14.45C1.7 14.6754 1.78955 14.8916 1.94896 15.051C2.10837 15.2104 2.32457 15.3 2.55 15.3H12.0445C11.9481 15.027 11.8992 14.7395 11.9 14.45V1.7H1.7ZM3.4 8.5H10.2V10.2H3.4V8.5ZM3.4 11.9H10.2V13.6H3.4V11.9ZM3.4 3.4H10.2V6.8H3.4V3.4Z"
                           fill="#BEC9D9" />
                       </g>
                       <defs>
                         <clipPath id="clip0_268_82">
                           <rect width="17" height="17" fill="white" />
                         </clipPath>
                       </defs>
                     </svg>
                 
                   </span>
                   <span class="menu-title">Paper Vendor</span>
                 </a>
                 <div class="sub-menu-list">
                   <ul>
                     <li class="menu-item">
                       <a href="#">
                         <span class="menu-title">Grid</span>
                       </a>
                     </li>
                   </ul>
                 </div>
                 </li>
                 <li class="menu-item sub-menu">
                 <a>
                   <span class="menu-icon">
                     <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                       <path
                         d="M10.5 1.3125C6.47062 1.3125 2.1875 2.38612 2.1875 4.375V16.625C2.1875 18.6139 6.47062 19.6875 10.5 19.6875C14.5294 19.6875 18.8125 18.6139 18.8125 16.625V4.375C18.8125 2.38612 14.5294 1.3125 10.5 1.3125ZM10.5 15.3125C5.89137 15.3125 3.0625 14.0385 3.0625 13.125V11.9289C4.52025 12.9973 7.5775 13.5625 10.5 13.5625C13.4225 13.5625 16.4797 12.9973 17.9375 11.9289V13.125C17.9375 14.0385 15.1086 15.3125 10.5 15.3125ZM10.5 11.8125C5.89137 11.8125 3.0625 10.5385 3.0625 9.625V8.428C4.52025 9.49725 7.5775 10.0625 10.5 10.0625C13.4225 10.0625 16.4797 9.49725 17.9375 8.428V9.625C17.9375 10.5385 15.1086 11.8125 10.5 11.8125ZM17.9375 16.625C17.9375 17.5385 15.1086 18.8125 10.5 18.8125C5.89137 18.8125 3.0625 17.5385 3.0625 16.625V15.4289C4.52025 16.4972 7.5775 17.0625 10.5 17.0625C13.4225 17.0625 16.4797 16.4972 17.9375 15.4289V16.625ZM10.5 8.3125C5.89137 8.3125 3.0625 7.0385 3.0625 6.125V4.375C3.0625 3.4615 5.89137 2.1875 10.5 2.1875C15.1086 2.1875 17.9375 3.4615 17.9375 4.375V6.125C17.9375 7.0385 15.1086 8.3125 10.5 8.3125Z"
                         fill="#BEC9D9" />
                     </svg>
                 
                   </span>
                   <span class="menu-title">Books Database</span>
                 </a>
                 <div class="sub-menu-list">
                   <ul>
                     <li class="menu-item ">
                       <a href="#">
                         <span class="menu-title">Grid</span>
                       </a>
                     </li>
                 
                   </ul>
                 </div>
                 </li> -->
          <!-- sub-menu -->

          <li data-bs-toggle="collapse"
            class="menu-item sub-menu {{ Route::is('settings.vendor.service-type.index','settings.vendor.service-type.add','settings.vendor.service-type.edit','settings.papersettings.paper_category_list', 'settings.papersettings.add_paper_category','settings.papersettings.edit_paper_category','settings.papersettings.add_paper_color','settings.papersettings.paper_color_list','settings.papersettings.edit_paper_color','settings.papersettings.paper_quality_list','settings.papersettings.add_paper_quality', 'settings.papersettings.edit_paper_quality','settings.papersettings.paper_thickness_list','settings.papersettings.add_paper_thickness', 'settings.papersettings.edit_paper_thickness','settings.papersettings.edit-paper-size','settings.papersettings.add-paper-size','settings.papersettings.paper-size','settings.papersettings.quantity-calculation','settings.papersettings.add-quantity','settings.papersettings.edit-paper-quantity','settings.papersettings.quantity-units','settings.papersettings.add-quantityunits','settings.papersettings.edit-quantityunits','settings.papersettings.size-units','settings.papersettings.add-sizeunits','settings.papersettings.edit-sizeunits') ? 'open active' : null }}">
            <a data-bs-toggle="collapse">
              <span class="menu-icon">
                <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M10.6925 1.75H10.3075C9.84337 1.75 9.39825 1.93437 9.07006 2.26256C8.74188 2.59075 8.5575 3.03587 8.5575 3.5V3.6575C8.55719 3.96438 8.47618 4.26579 8.3226 4.53148C8.16902 4.79717 7.94827 5.01781 7.6825 5.17125L7.30625 5.39C7.04022 5.54359 6.73844 5.62446 6.43125 5.62446C6.12406 5.62446 5.82229 5.54359 5.55625 5.39L5.425 5.32C5.02343 5.08835 4.54636 5.02551 4.0985 5.14527C3.65065 5.26503 3.26861 5.55759 3.03625 5.95875L2.84375 6.29125C2.61211 6.69282 2.54926 7.16989 2.66902 7.61775C2.78878 8.0656 3.08135 8.44764 3.4825 8.68L3.61375 8.7675C3.87824 8.9202 4.09817 9.13945 4.25167 9.40348C4.40517 9.6675 4.48691 9.9671 4.48875 10.2725V10.7188C4.48998 11.0271 4.4097 11.3303 4.25604 11.5977C4.10238 11.8651 3.88081 12.0871 3.61375 12.2412L3.4825 12.32C3.08135 12.5524 2.78878 12.9344 2.66902 13.3823C2.54926 13.8301 2.61211 14.3072 2.84375 14.7087L3.03625 15.0413C3.26861 15.4424 3.65065 15.735 4.0985 15.8547C4.54636 15.9745 5.02343 15.9116 5.425 15.68L5.55625 15.61C5.82229 15.4564 6.12406 15.3755 6.43125 15.3755C6.73844 15.3755 7.04022 15.4564 7.30625 15.61L7.6825 15.8288C7.94827 15.9822 8.16902 16.2028 8.3226 16.4685C8.47618 16.7342 8.55719 17.0356 8.5575 17.3425V17.5C8.5575 17.9641 8.74188 18.4092 9.07006 18.7374C9.39825 19.0656 9.84337 19.25 10.3075 19.25H10.6925C11.1566 19.25 11.6017 19.0656 11.9299 18.7374C12.2581 18.4092 12.4425 17.9641 12.4425 17.5V17.3425C12.4428 17.0356 12.5238 16.7342 12.6774 16.4685C12.831 16.2028 13.0517 15.9822 13.3175 15.8288L13.6938 15.61C13.9598 15.4564 14.2616 15.3755 14.5688 15.3755C14.8759 15.3755 15.1777 15.4564 15.4438 15.61L15.575 15.68C15.9766 15.9116 16.4536 15.9745 16.9015 15.8547C17.3494 15.735 17.7314 15.4424 17.9638 15.0413L18.1563 14.7C18.3879 14.2984 18.4507 13.8214 18.331 13.3735C18.2112 12.9256 17.9187 12.5436 17.5175 12.3112L17.3863 12.2412C17.1192 12.0871 16.8976 11.8651 16.744 11.5977C16.5903 11.3303 16.51 11.0271 16.5113 10.7188V10.2812C16.51 9.97288 16.5903 9.66967 16.744 9.40231C16.8976 9.13494 17.1192 8.91293 17.3863 8.75875L17.5175 8.68C17.9187 8.44764 18.2112 8.0656 18.331 7.61775C18.4507 7.16989 18.3879 6.69282 18.1563 6.29125L17.9638 5.95875C17.7314 5.55759 17.3494 5.26503 16.9015 5.14527C16.4536 5.02551 15.9766 5.08835 15.575 5.32L15.4438 5.39C15.1777 5.54359 14.8759 5.62446 14.5688 5.62446C14.2616 5.62446 13.9598 5.54359 13.6938 5.39L13.3175 5.17125C13.0517 5.01781 12.831 4.79717 12.6774 4.53148C12.5238 4.26579 12.4428 3.96438 12.4425 3.6575V3.5C12.4425 3.03587 12.2581 2.59075 11.9299 2.26256C11.6017 1.93437 11.1566 1.75 10.6925 1.75Z"
                    stroke="#BEC9D9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                  <path
                    d="M10.5 13.125C11.9497 13.125 13.125 11.9497 13.125 10.5C13.125 9.05025 11.9497 7.875 10.5 7.875C9.05025 7.875 7.875 9.05025 7.875 10.5C7.875 11.9497 9.05025 13.125 10.5 13.125Z"
                    stroke="#BEC9D9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </span>
              <span class="menu-title">Settings</span>
            </a>
            <div class="sub-menu-list" data-bs-toggle="collapse" data-popper-escaped="" data-popper-placement="right"
              style="position: fixed; left: 0px; top: 0px; margin: 0px; visibility: hidden; transform: translate3d(280px, 355.2px, 0px);">
              <ul>
                <li
                  class="menu-item {{ Route::is('settings.vendor.service-type.index','settings.vendor.service-type.add','settings.vendor.service-type.edit') ? 'active' : null }}">
                  <a href="{{ route('settings.vendor.service-type.index') }}">
                    <span class="menu-title">Vendor Settings</span>
                  </a>
                </li>
                <li
                  class="menu-item sub-menu {{ Route::is('settings.papersettings.paper_category_list', 'settings.papersettings.add_paper_category','settings.papersettings.edit_paper_category','settings.papersettings.add_paper_color','settings.papersettings.paper_color_list','settings.papersettings.edit_paper_color','settings.papersettings.paper_quality_list','settings.papersettings.add_paper_quality', 'settings.papersettings.edit_paper_quality','settings.papersettings.paper_thickness_list','settings.papersettings.add_paper_thickness', 'settings.papersettings.edit_paper_thickness','settings.papersettings.edit-paper-size','settings.papersettings.add-paper-size','settings.papersettings.paper-size','settings.papersettings.quantity-calculation','settings.papersettings.add-quantity','settings.papersettings.edit-paper-quantity','settings.papersettings.quantity-units','settings.papersettings.add-quantityunits','settings.papersettings.edit-quantityunits','settings.papersettings.size-units','settings.papersettings.add-sizeunits','settings.papersettings.edit-sizeunits') ? 'open active' : null }}">
                  <a><span class="menu-title">Service Settings</span></a>
                  <div class="sub-menu-list" data-bs-toggle="collapse" data-popper-escaped=""
                    data-popper-placement="right"
                    style="left: 0px; top: 0px; margin-right: 0px; margin-left: 0px; box-sizing: border-box; display: none;">
                    <ul>
                      <li
                        class="menu-item {{ Route::is('settings.papersettings.paper_category_list','settings.papersettings.edit_paper_category', 'settings.papersettings.add_paper_category') ? 'active' : null }}">
                        <a href="{{ route('settings.papersettings.paper_category_list') }}">
                          <span class="menu-title">Paper Category</span>
                        </a>
                      </li>
                      <li
                        class="menu-item {{ Route::is('settings.papersettings.paper-size','settings.papersettings.add-paper-size', 'settings.papersettings.edit-paper-size','settings.papersettings.edit-paper-size','settings.papersettings.add-paper-size','settings.papersettings.paper-size') ? 'active' : null }}">
                        <a href="{{ route('settings.papersettings.paper-size') }}">
                          <span class="menu-title">Paper Size</span>
                        </a>
                      </li>
                      <li class="menu-item {{ Route::is('settings.papersettings.size-units', 'settings.papersettings.add-sizeunits', 'settings.papersettings.edit-sizeunits') ? 'active' : null }}">
                        <a href="{{ route('settings.papersettings.size-units') }}">
                          <span class="menu-title">Paper Size Units</span>
                        </a>
                      </li>
                      <li
                        class="menu-item {{ Route::is('settings.papersettings.paper_color_list','settings.papersettings.add_paper_color','settings.papersettings.edit_paper_color') ? 'active' : null }}">
                        <a href="{{ route('settings.papersettings.paper_color_list') }}">
                          <span class="menu-title">Paper Color</span>
                        </a>
                      </li>
                      <li
                        class="menu-item {{ Route::is('settings.papersettings.paper_quality_list','settings.papersettings.add_paper_quality', 'settings.papersettings.edit_paper_quality') ? 'active' : null }} ">
                        <a href="{{ route('settings.papersettings.paper_quality_list') }}">
                          <span class="menu-title">Paper Quality</span>
                        </a>
                      </li>
                      <li class="menu-item {{ Route::is('settings.papersettings.paper_thickness_list','settings.papersettings.add_paper_thickness', 'settings.papersettings.edit_paper_thickness') ? 'active' : null }}">
                        <a href="{{ route('settings.papersettings.paper_thickness_list') }}">
                          <span class="menu-title">Paper GSM</span>
                        </a>
                      </li>

                      <li class="menu-item {{ Route::is('settings.papersettings.quantity-calculation', 'settings.papersettings.add-quantity', 'settings.papersettings.edit-paper-quantity') ? 'active' : null }}">
                        <a href="{{ route('settings.papersettings.quantity-calculation') }}">
                          <span class="menu-title">Paper Quantity Calculation</span>
                        </a>
                      </li>

                      <li class="menu-item {{ Route::is('settings.papersettings.quantity-units', 'settings.papersettings.add-quantityunits', 'settings.papersettings.edit-quantityunits') ? 'active' : null }}">
                        <a href="{{ route('settings.papersettings.quantity-units') }}">
                          <span class="menu-title">Paper Quantity Units</span>
                        </a>
                      </li>

                    </ul>
                  </div>
                </li>
              </ul>
            </div>
          </li>
        </ul>
      </nav>
    </div>
  </div>
</aside>