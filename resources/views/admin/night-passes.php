@extends('admin.layout.master')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <ul class="breadcrumb breadcrumb-style ">
            <li class="breadcrumb-item">
              <h4 class="page-title m-b-0">Night Passes</h4>
            </li>
            <li class="breadcrumb-item">
              <a href="index.php">
                <i data-feather="home"></i></a>
            </li>
            <li class="breadcrumb-item">Night Passes</li>
           
          </ul>
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Night Time Guest Parking (10 PM - 6 AM)</h4>
                  </div>
       
                </div>
              </div>
            </div>
   
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <!--<h4>Table With State Save</h4>-->
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped table-hover" id="save-stage" style="width:100%;">
                        <thead>
                          <tr>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Date</th>
                            <th>Apartment No</th>
                            <th>Passcode</th>
                            <th>Make/Model/Color</th>
                            <th>License Plate#</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>James</td>
                            <td>123-123-1324</td>
                            <td>08-04-2025</td>
                            <td>1457 N Halsted St, Chicago, IL 60642</td>
                            <td>75462</td>
                            <td>Honda/301/Gray</td>
                            <td>A24-432</td>
                          </tr>
                         <tr>
                            <td>James</td>
                            <td>123-123-1324</td>
                            <td>08-04-2025</td>
                            <td>1457 N Halsted St, Chicago, IL 60642</td>
                            <td>02116</td>
                            <td>Honda/301/Gray</td>
                            <td>A24-432</td>
                          </tr>
                          <<tr>
                            <td>James</td>
                            <td>123-123-1324</td>
                            <td>08-04-2025</td>
                            <td>1457 N Halsted St, Chicago, IL 60642</td>
                            <td>10007</td>
                            <td>Honda/301/Gray</td>
                            <td>A24-432</td>
                          </tr>
                          <tr>
                            <td>James</td>
                            <td>123-123-1324</td>
                            <td>08-04-2025</td>
                            <td>1457 N Halsted St, Chicago, IL 60642</td>
                            <td>75462</td>
                            <td>Honda/301/Gray</td>
                            <td>A24-432</td>
                          </tr>
                          <tr>
                            <td>James</td>
                            <td>123-123-1324</td>
                            <td>08-04-2025</td>
                            <td>1457 N Halsted St, Chicago, IL 60642</td>
                            <td>02116</td>
                            <td>Honda/301/Gray</td>
                            <td>A24-432</td>
                          </tr>
                          <tr>
                            <td>James</td>
                            <td>123-123-1324</td>
                            <td>08-04-2025</td>
                            <td>1457 N Halsted St, Chicago, IL 60642</td>
                            <td>10007</td>
                            <td>Honda/301/Gray</td>
                            <td>A24-432</td>
                          </tr>
                          <tr>
                            <td>James</td>
                            <td>123-123-1324</td>
                            <td>08-04-2025</td>
                            <td>1457 N Halsted St, Chicago, IL 60642</td>
                            <td>75462</td>
                            <td>Honda/301/Gray</td>
                            <td>A24-432</td>
                          </tr>
                          <tr>
                            <td>James</td>
                            <td>123-123-1324</td>
                            <td>08-04-2025</td>
                            <td>1457 N Halsted St, Chicago, IL 60642</td>
                            <td>02116</td>
                            <td>Honda/301/Gray</td>
                            <td>A24-432</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <div class="settingSidebar">
          <a href="javascript:void(0)" class="settingPanelToggle"> <i class="fa fa-spin fa-cog"></i>
          </a>
          <div class="settingSidebar-body ps-container ps-theme-default">
            <div class=" fade show active">
              <div class="setting-panel-header">Setting Panel
              </div>
              <div class="p-15 border-bottom">
                <h6 class="font-medium m-b-10">Select Layout</h6>
                <div class="selectgroup layout-color w-50">
                  <label class="selectgroup-item">
                    <input type="radio" name="value" value="1" class="selectgroup-input-radio select-layout" checked>
                    <span class="selectgroup-button">Light</span>
                  </label>
                  <label class="selectgroup-item">
                    <input type="radio" name="value" value="2" class="selectgroup-input-radio select-layout">
                    <span class="selectgroup-button">Dark</span>
                  </label>
                </div>
              </div>
              <div class="p-15 border-bottom">
                <h6 class="font-medium m-b-10">Sidebar Color</h6>
                <div class="selectgroup selectgroup-pills sidebar-color">
                  <label class="selectgroup-item">
                    <input type="radio" name="icon-input" value="1" class="selectgroup-input select-sidebar">
                    <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip"
                      data-original-title="Light Sidebar"><i class="fas fa-sun"></i></span>
                  </label>
                  <label class="selectgroup-item">
                    <input type="radio" name="icon-input" value="2" class="selectgroup-input select-sidebar" checked>
                    <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip"
                      data-original-title="Dark Sidebar"><i class="fas fa-moon"></i></span>
                  </label>
                </div>
              </div>
              <div class="p-15 border-bottom">
                <h6 class="font-medium m-b-10">Color Theme</h6>
                <div class="theme-setting-options">
                  <ul class="choose-theme list-unstyled mb-0">
                    <li title="white" class="active">
                      <div class="white"></div>
                    </li>
                    <li title="cyan">
                      <div class="cyan"></div>
                    </li>
                    <li title="black">
                      <div class="black"></div>
                    </li>
                    <li title="purple">
                      <div class="purple"></div>
                    </li>
                    <li title="orange">
                      <div class="orange"></div>
                    </li>
                    <li title="green">
                      <div class="green"></div>
                    </li>
                    <li title="red">
                      <div class="red"></div>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="p-15 border-bottom">
                <div class="theme-setting-options">
                  <label class="m-b-0">
                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input"
                      id="mini_sidebar_setting">
                    <span class="custom-switch-indicator"></span>
                    <span class="control-label p-l-10">Mini Sidebar</span>
                  </label>
                </div>
              </div>
              <div class="p-15 border-bottom">
                <div class="theme-setting-options">
                  <label class="m-b-0">
                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input"
                      id="sticky_header_setting">
                    <span class="custom-switch-indicator"></span>
                    <span class="control-label p-l-10">Sticky Header</span>
                  </label>
                </div>
              </div>
              <div class="mt-4 mb-4 p-3 align-center rt-sidebar-last-ele">
                <a href="#" class="btn btn-icon icon-left btn-primary btn-restore-theme">
                  <i class="fas fa-undo"></i> Restore Default
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; 2025 <div class="bullet"></div> Design By <a href="#">Redstar</a>
        </div>
        <div class="footer-right">
        </div>
      </footer>
    </div>
  </div>
  <!-- General JS Scripts -->
  <script src="assets/js/app.min.js"></script>
  <!-- JS Libraies -->
  <script src="assets/bundles/datatables/datatables.min.js"></script>
  <script src="assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
  <script src="assets/bundles/jquery-ui/jquery-ui.min.js"></script>
  <!-- Page Specific JS File -->
  <script src="assets/js/page/datatables.js"></script>
  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <!-- Custom JS File -->
  <script src="assets/js/custom.js"></script>
</body>


<!-- Mirrored from www.radixtouch.in/templates/admin/gati/source/light/datatables.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 11 Mar 2021 12:38:10 GMT -->

</html>