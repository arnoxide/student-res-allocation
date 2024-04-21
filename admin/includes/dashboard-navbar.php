<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="dashboard" class="app-brand-link">
              <span class="app-brand-logo demo">
            <!-- logo svg goes in here -->
              </span>
              <span class="app-brand-text demo menu-text fw-bolder ms-2">Allocation.</span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            <!-- Dashboard -->
            <li class="menu-item">
              <a href="dashboard" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
              </a>
            </li>


                <li class="menu-item">
                  <a href="residence" class="menu-link" >
                    <div data-i18n="Basic">Residence</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="students" class="menu-link" >
                    <div data-i18n="Basic">Students</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="pendingApplication" class="menu-link" >
                    <div data-i18n="Basic">Pending Application</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="approvedApplication" class="menu-link" >
                    <div data-i18n="Basic">Approved Application</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="rejectedApplication" class="menu-link" >
                    <div data-i18n="Basic">Rejected Application</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="AssignedApplication" class="menu-link" >
                    <div data-i18n="Basic">Assigned Application</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="canceledApplication" class="menu-link" >
                    <div data-i18n="Basic">Canceled Application</div>
                  </a>
                </li>

        
          
            </li>
           
          
           
          </ul>
        </aside>
        <!-- / Menu -->

        <script>
          // Get the current URL
var currentPageURL = window.location.href;

// Select all menu items
var menuItems = document.querySelectorAll('.menu-item');

// Loop through each menu item
menuItems.forEach(function(item) {
    // Get the link of the menu item
    var menuItemURL = item.querySelector('.menu-link').getAttribute('href');
    
    // Check if the current page URL matches the menu item URL
    if (currentPageURL.includes(menuItemURL)) {
        // Add the 'active' class to the parent <li> element
        item.classList.add('active');
    }
});

        </script>