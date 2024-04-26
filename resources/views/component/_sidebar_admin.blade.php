
    <div class="sidebar" data-color="orange">
        <!--
        Tip 1: You can change the color of the fdebar using: data-color="blue | green | orange | red | yellow"
        -->
      <div class="logo">
        <a href="http://www.creative-tim.com" class="simple-text logo-mini">
          
        </a>
        <a href="{{ route('home') }}" class="simple-text logo-normal">
          {{ App\Models\Company::take(1)->first()->name }}
        </a>
      </div>
      <div class="sidebar-wrapper" id="sidebar-wrapper">
        <ul class="nav">
          <li class="nav-item {{ request()->is('admin/dashboard') || request()->is('home') ?'active' : '' }}">
            <a href="{{ route('admin.dashboard.index') }}">
              <i class="now-ui-icons design_app"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li>  
            <a data-toggle="collapse" href="#akun" @if (request()->is('admin/admin') || request()->is('admin/cashier') || request()->is('admin/customer') || request()->is('admin/customer/detail-shopping/*') ) 
              aria-expanded="true" @endif>
            <i class="now-ui-icons users_single-02"></i>
            <p>Akun<b class="caret"></b></p>
            </a>
            <div class="collapse {{ request()->is('admin/admin') || request()->is('admin/cashier') || request()->is('admin/customer') || request()->is('admin/customer/detail-shopping/*') ?'show' : '' }}" id="akun">
              <ul class="nav">
                <li class="{{ request()->is('admin/admin') ?'active' : '' }}">
                  <a href="{{ route('admin.admin.index') }}">
                    <i class="now-ui-icons arrows-1_minimal-right"></i>
                  <span class="sidebar-normal">Admin</span>
                  </a>
                </li>
                <li class="{{ request()->is('admin/cashier') ?'active' : '' }}">
                  <a href="{{ route('admin.cashier.index') }}">
                    <i class="now-ui-icons arrows-1_minimal-right"></i>
                  <span class="sidebar-normal">Kasir</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>

          <li>
            <a data-toggle="collapse" href="#kategori" @if (request()->is('admin/category') || request()->is('admin/category-item'))
              aria-expanded="true" @endif>
            <i class="now-ui-icons design_app"></i>
            <p>Kategori<b class="caret"></b></p>
            </a>
            <div class="collapse {{ request()->is('admin/category') || request()->is('admin/category-item') ?'show' : '' }}" id="kategori">
              <ul class="nav">
                <li class="{{ request()->is('admin/category') ?'active' : '' }}">
                  <a href="{{ route('admin.category.index') }}">
                    <i class="now-ui-icons arrows-1_minimal-right"></i>
                  <span class="sidebar-normal">Kategori Produk</span>
                  </a>
                </li>
                <li class="{{ request()->is('admin/category-item') ?'active' : '' }}">
                  <a href="{{ route('admin.category-item.index') }}">
                    <i class="now-ui-icons arrows-1_minimal-right"></i>
                  <span class="sidebar-normal">Kategori Item</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item {{ request()->is('admin/product') ?'active' : '' }}">
            <a href="{{ route('admin.product.index') }}">
              <i class="now-ui-icons shopping_box"></i>
              <p>Produk</p>
            </a>
          </li>
          <li class="nav-item {{ request()->is('admin/transaction') ?'active' : '' }}">
            <a href="{{ route('admin.transaction.index') }}" target="_blank">
              <i class="now-ui-icons shopping_cart-simple"></i>
              <p>Transaksi</p>
            </a>
          </li>
          <li>
            <a data-toggle="collapse" href="#laporan" @if (request()->is('admin/report') || request()->is('admin/report/show/*') || request()->is('admin/opname') || request()->is('admin/return') || request()->is('admin/supply') || request()->is('admin/supply/addProduct') || request()->is('admin/supply/*') || request()->is('admin/supply/show/*') || request()->is('admin/operating-cost') || request()->is('admin/best-selling') || request()->is('admin/daily-use-product/report'))
              aria-expanded="true" @endif>
            <i class="now-ui-icons education_paper"></i>
            <p>Laporan<b class="caret"></b></p>
            </a>
            <div class="collapse {{ request()->is('admin/report') || request()->is('admin/report/show/*') || request()->is('admin/opname') || request()->is('admin/return') || request()->is('admin/supply') || request()->is('admin/supply/addProduct') || request()->is('admin/supply/*') || request()->is('admin/supply/show/*') || request()->is('admin/operating-cost') || request()->is('admin/profit-loss') || request()->is('admin/best-selling') || request()->is('admin/daily-use-product/report') ?'show' : '' }}" id="laporan">
              <ul class="nav">
                <li class="{{ request()->is('admin/profit-loss') ?'active' : '' }}">
                  <a href="{{ route('admin.profit-loss.index') }}">
                    <i class="now-ui-icons arrows-1_minimal-right"></i>
                  <span class="sidebar-normal">Untung / Rugi</span>
                  </a>
                </li>
                <li class="{{ request()->is('admin/report') || request()->is('admin/report/show/*') ?'active' : '' }}">
                  <a href="{{ route('admin.report.index') }}">
                    <i class="now-ui-icons arrows-1_minimal-right"></i>
                  <span class="sidebar-normal">Laporan Penjualan</span>
                  </a>
                </li>
                <li class="{{ request()->is('admin/supply') || request()->is('admin/supply/addProduct') || request()->is('admin/supply/show/*')  ?'active' : '' }}">
                  <a href="{{ route('admin.supply.index') }}">
                    <i class="now-ui-icons arrows-1_minimal-right"></i>
                  <span class="sidebar-normal">Laporan Pembelian (Supplier)</span>
                  </a>
                </li>
                <li class="{{ request()->is('admin/best-selling') ?'active' : '' }}">
                  <a href="{{ route('admin.best-selling.index') }}">
                    <i class="now-ui-icons arrows-1_minimal-right"></i>
                  <span class="sidebar-normal">Barang Terlaris</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item {{ request()->is('admin/setting') ?'active' : '' }}">
            <a href="{{ route('admin.setting.index') }}">
              <i class="now-ui-icons ui-1_settings-gear-63"></i>
              <p>Pengaturan</p>
            </a>
          </li>
          <li class="nav-item {{ request()->is('admin/profile') ?'active' : '' }}">
            <a href="{{ route('admin.profile.index') }}">
              <i class="now-ui-icons business_badge"></i>
              <p>Akun Saya</p>
            </a>
          </li>
        </ul>
      </div>
    </div>