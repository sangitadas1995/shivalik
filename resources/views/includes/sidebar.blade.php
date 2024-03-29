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
            <a href="{{ route('users.index') }}"><span class="w-100"><img src="{{ asset('images/mi_user.png') }}" />
                <br />User
                Management</span></a>
          </li>
          <li>
            <a href="{{ route('customers.index') }}">
              <span class="w-100"><img src="{{ asset('images/customer.png') }}" /> <br />
                Customers</span></a>
          </li>
          <li>
            <a href="{{ route('orders.index') }}"><span class="w-100"><img src="{{ asset('images/order-approve-outline-sharp.png') }}" />
                <br />
                Order Management</span></a>
          </li>
          <li>
            <a href="{{ route('inventory.index') }}"><span class="w-100"><img src="{{ asset('images/ic_round-inventory.png') }}" /><br />
                Inventory Management</span></a>
          </li>
        </ul>
      </div>
      <nav class="menu open-current-submenu">
        <ul>
          <li class="menu-item">
            <a href="{{ route('vendors.index') }}">
              <span class="menu-icon">
                <i class="ri-layout-3-fill"></i>
              </span>
              <span class="menu-title">Vendor Management</span>
            </a>
          </li>
          <!-- sub-menu -->
          <li class="menu-item sub-menu">
            <a href="#">
              <span class="menu-icon">
                <i class="ri-focus-2-fill"></i>
              </span>
              <span class="menu-title">Printing Vendor</span>
            </a>
            <div class="sub-menu-list">
              <ul>
                <li class="menu-item">
                  <a href="#">
                    <span class="menu-title">Grid</span>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="#">
                    <span class="menu-title">Layout</span>
                  </a>
                </li>
                <li class="menu-item sub-menu">
                  <a href="#">
                    <span class="menu-title">Forms</span>
                  </a>
                  <div class="sub-menu-list">
                    <ul>
                      <li class="menu-item">
                        <a href="#">
                          <span class="menu-title">Input</span>
                        </a>
                      </li>
                      <li class="menu-item">
                        <a href="#">
                          <span class="menu-title">Select</span>
                        </a>
                      </li>
                      <li class="menu-item sub-menu">
                        <a href="#">
                          <span class="menu-title">More</span>
                        </a>
                        <div class="sub-menu-list">
                          <ul>
                            <li class="menu-item">
                              <a href="#">
                                <span class="menu-title">CheckBox</span>
                              </a>
                            </li>
                            <li class="menu-item">
                              <a href="#">
                                <span class="menu-title">Radio</span>
                              </a>
                            </li>
                            <li class="menu-item sub-menu">
                              <a href="#">
                                <span class="menu-title">Want more ?</span>
                                <span class="menu-suffix">&#x1F914;</span>
                              </a>
                              <div class="sub-menu-list">
                                <ul>
                                  <li class="menu-item">
                                    <a href="#">
                                      <span class="menu-prefix">&#127881;</span>
                                      <span class="menu-title">You made it
                                      </span>
                                    </a>
                                  </li>
                                </ul>
                              </div>
                            </li>
                          </ul>
                        </div>
                      </li>
                    </ul>
                  </div>
                </li>
              </ul>
            </div>
          </li>
          <li class="menu-item">
            <a href="#">
              <span class="menu-icon">
                <i class="ri-layout-3-fill"></i>
              </span>
              <span class="menu-title">Printing Plate Vendor</span>
            </a>
          </li>
          <li class="menu-item">
            <a href="loi-timeline.html">
              <span class="menu-icon">
                <i class="ri-pie-chart-2-fill"></i>
              </span>
              <span class="menu-title">Paper Vendor</span>
            </a>

          </li>
          <li class="menu-item">
            <a href="records.html">
              <span class="menu-icon">
                <i class="ri-global-fill"></i>
              </span>
              <span class="menu-title">Books Database</span>
            </a>

          </li>
          <li class="menu-item sub-menu">
            <a>
              <span class="menu-icon">
                <i class="ri-file-list-3-fill"></i>
              </span>
              <span class="menu-title">Settings</span>
            </a>
            <div class="sub-menu-list" data-popper-escaped="" data-popper-placement="right"
              style="position: fixed; left: 0px; top: 0px; margin: 0px; visibility: hidden; transform: translate3d(280px, 355.2px, 0px);">
              <ul>
                <li class="menu-item">
                  <a href="#">
                    <span class="menu-title">Paper Type</span>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="#">
                    <span class="menu-title">Color Type</span>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="#">
                    <span class="menu-title">Book Cover Type</span>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="#">
                    <span class="menu-title">Binding Type</span>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="#">
                    <span class="menu-title">Printing Machine Type</span>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="#">
                    <span class="menu-title">General Setting</span>
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