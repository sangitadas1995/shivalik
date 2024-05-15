<div class="sidebar-wraper " id="sidebar-wraper">
  <aside id="sidebar" class="sidebar break-point-lg has-bg-image">

    <div class="sidebar-layout">
      <div class="sidebar-header">
        <span class="logo-span-big"><img src="{{ asset('images/logo1.png') }}" class="w-100" /></span>
        <span class="logo-span-small"><img src="{{ asset('images/shivalikh-logo-remove-name.png') }}"
            class="w-100" /></span>
      </div>
      <div class="sidebar-content">
        <div class="ul-box top-squar-links hover-clone-div">
          <ul class="row ">
            <li>
              <a href="{{ route('users.index') }}"
                class="{{ Route::is('users.index','users.add', 'users.edit') ? 'activeBox' : null }}">
                <span class="imgSpan"><img src="{{ asset('images/mi_user.png') }}" />
                </span><span>User <br> Management</span>
              </a>
            </li>
            <li>
              <a href="{{ route('customers.index') }}"
                class="{{ Route::is('customers.index','customers.add', 'customers.edit') ? 'activeBox' : null }}">
                <span class="imgSpan"><img src="{{ asset('images/customer.png') }}" />
                </span><span>Customers</span>
              </a>
            </li>
            <li>
              <a href="{{ route('orders.index') }}"
                class="{{ Route::is('orders.index','orders.add', 'orders.view') ? 'activeBox' : null }}">
                <span class="imgSpan"><img src="{{ asset('images/order-approve-outline-sharp.png') }}" />
                </span><span>Order <br> Management</span>
              </a>
            </li>
            <li>
              <a href="{{ route('inventory.warehouse.list') }}"
                class="{{ Route::is('inventory.index','inventory.add-product-stock','inventory.details','inventory.warehouse.add','inventory.warehouse.list','inventory.warehouse.edit') ? 'activeBox' : null }}">
                <span class="imgSpan"><img src="{{ asset('images/ic_round-inventory.png') }}" />
                </span><span>Inventory <br> Management</span>
              </a>
            </li>
          </ul>
        </div>
        <nav class="menu open-current-submenu hover-clone-div">
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
          
            
            <!-- sub-menu -->

            <li data-bs-toggle="collapse"
              class="menu-item sub-menu {{ Route::is('settings.vendor.service-type.index','settings.vendor.service-type.add','settings.vendor.service-type.edit','settings.papersettings.paper_category_list', 'settings.papersettings.add_paper_category','settings.papersettings.edit_paper_category','settings.papersettings.add_paper_color','settings.papersettings.paper_color_list','settings.papersettings.edit_paper_color','settings.papersettings.paper_quality_list','settings.papersettings.add_paper_quality', 'settings.papersettings.edit_paper_quality','settings.papersettings.paper_thickness_list','settings.papersettings.add_paper_thickness', 'settings.papersettings.edit_paper_thickness','settings.papersettings.edit-paper-size','settings.papersettings.add-paper-size','settings.papersettings.paper-size','settings.papersettings.quantity-calculation','settings.papersettings.add-quantity','settings.papersettings.edit-paper-quantity','settings.papersettings.quantity-units','settings.papersettings.add-quantityunits','settings.papersettings.edit-quantityunits','settings.papersettings.size-units','settings.papersettings.add-sizeunits','settings.papersettings.edit-sizeunits','settings.edit-profile') ? 'open active' : null }}">
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
                        <li
                          class="menu-item {{ Route::is('settings.papersettings.size-units', 'settings.papersettings.add-sizeunits', 'settings.papersettings.edit-sizeunits') ? 'active' : null }}">
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
                        <li
                          class="menu-item {{ Route::is('settings.papersettings.paper_thickness_list','settings.papersettings.add_paper_thickness', 'settings.papersettings.edit_paper_thickness') ? 'active' : null }}">
                          <a href="{{ route('settings.papersettings.paper_thickness_list') }}">
                            <span class="menu-title">Paper GSM</span>
                          </a>
                        </li>

                        <li
                          class="menu-item {{ Route::is('settings.papersettings.quantity-calculation', 'settings.papersettings.add-quantity', 'settings.papersettings.edit-paper-quantity') ? 'active' : null }}">
                          <a href="{{ route('settings.papersettings.quantity-calculation') }}">
                            <span class="menu-title">Paper Quantity Calculation</span>
                          </a>
                        </li>

                        <li
                          class="menu-item {{ Route::is('settings.papersettings.quantity-units', 'settings.papersettings.add-quantityunits', 'settings.papersettings.edit-quantityunits') ? 'active' : null }}">
                          <a href="{{ route('settings.papersettings.quantity-units') }}">
                            <span class="menu-title">Paper Quantity Units</span>
                          </a>
                        </li>

                      </ul>
                    </div>
                  </li>
                  <li
                  class="menu-item {{ Route::is('settings.edit-profile') ? 'active' : null }}">
                  <a href="{{ route('settings.edit-profile') }}">
                    <span class="menu-title">Admin Profile Settings</span>
                  </a>
                </li>
                </ul>
              </div>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </aside>
  <div id="overlay" class="overlay"></div>
</div>
<div id="sidebar-hover-showBox" style="height: fit-content;"
  class="sidebar sidebar-hover-showBox sidebar-wraper-small sidebar-wraper overflow-visible">

</div>

<script>
  function onSidebarSmallTogglerClick(event) {
    if (document.getElementById('sidebar-wraper').classList.contains('sidebar-wraper-small')) {
      document.getElementById('sidebar-wraper').classList.remove('sidebar-wraper-small')
      document.getElementById('header').classList.remove('collepse-header')
    } else {
      document.getElementById('sidebar-wraper').classList.add('sidebar-wraper-small')
      document.getElementById('header').classList.add('collepse-header')
    }
  }
  [...document.querySelectorAll('.hover-clone-div li')].forEach((elem) => {
    elem.addEventListener('mouseover', (e) => {
      if (document.getElementById('sidebar-wraper').classList.contains('sidebar-wraper-small')) {
        let hoverShowBox = document.getElementById('sidebar-hover-showBox');
        hoverShowBox.innerHTML = "";
        hoverShowBox.style.top = elem.offsetTop + "px";
        // debugger
        let hoverShowElem = e.target.closest('.hover-clone-div').cloneNode(true);
        hoverShowElem.querySelector('ul').innerHTML = "";
        let elem_clone = elem.cloneNode(true);
        hoverShowElem.querySelector('ul').append(elem_clone);
        // console.log(hoverShowElem);
        hoverShowBox.append(hoverShowElem)
      }
    });


  })

  document.addEventListener('mousemove', (e) => {
    // console.log(e.target);
    if (e.target.classList.contains('hover-clone-div') || e.target.closest('.hover-clone-div')) {
      // console.log("yes");
    } else {
      let hoverShowBox = document.getElementById('sidebar-hover-showBox');
      hoverShowBox.innerHTML = "";
    }
  })

</script>