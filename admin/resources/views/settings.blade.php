<!DOCTYPE html>

<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta  name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no minimum-scale=1.0, maximum-scale=1.0"/>
    <title>settings</title>
    <meta name="description" content="" />

    <!-- headerscript -->
    @include('includes.header_script')

  </head>
  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
       @include('includes.sidebar')
        <!-- / Menu -->


        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->
          @include('includes.header')
          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Profile Setting/</span>edit my profile</h4>

              <!-- Basic Layout -->
              <div class="row">
              <div class="col-xl">
                  <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                      <h5 class="mb-0">Update Profile</h5>
                      <small class="text-muted float-end"></small>
                    </div>
                    <div class="card-body">
                      <form>
                      <div class="mb-3">
                        <label for="formFile" class="form-label">Update Site Backgroud Image:</label>
                        <input class="form-control" type="file" id="formFile" />
                      </div>
                        <div class="mb-3">
                          <label class="form-label" for="basic-icon-default-vendorname">Vendor Name</label>
                          <div class="input-group input-group-merge">
                            <span id="basic-icon-default-vendorname2" class="input-group-text"
                              ><i class="bx bx-user"></i></span>
                            <input
                              type="text"
                              class="form-control"
                              id="basic-icon-default-vendorname"
                              placeholder="John Doe"
                              aria-label="John Doe"
                              aria-describedby="basic-icon-default-vendorname2"/>
                          </div>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="basic-icon-default-email">Email</label>
                          <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                            <input
                              type="text"
                              id="basic-icon-default-email"
                              class="form-control"
                              placeholder="john.doe"
                              aria-label="john.doe"
                              aria-describedby="basic-icon-default-email2"
                            />
                            <span id="basic-icon-default-email2" class="input-group-text">@example.com</span>
                          </div>
                          <div class="form-text">You can use letters, numbers & periods</div>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="basic-icon-default-phone">Phone No</label>
                          <div class="input-group input-group-merge">
                            <span id="basic-icon-default-phone2" class="input-group-text"
                              ><i class="bx bx-phone"></i
                            ></span>
                            <input
                              type="text"
                              id="basic-icon-default-phone"
                              class="form-control phone-mask"
                              placeholder="658 799 8941"
                              aria-label="658 799 8941"
                              aria-describedby="basic-icon-default-phone2"
                            />
                          </div>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="basic-icon-default-address">Address</label>
                          <div class="input-group input-group-merge">
                          <span id="basic-icon-default-company2" class="input-group-text"
                              ><i class="bx bx-buildings"></i
                            ></span>
                            <textarea
                              id="basic-icon-default-addess"
                              class="form-control"
                              placeholder="Enter Your Street Line1"
                              aria-label="Enter Your Street Line1"
                              aria-describedby="basic-icon-default-message2"
                            ></textarea>
                          </div>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="basic-icon-default-message">Message</label>
                          <div class="input-group input-group-merge">
                            <span id="basic-icon-default-message2" class="input-group-text"
                              ><i class="bx bx-comment"></i
                            ></span>
                            <textarea
                              id="basic-icon-default-message"
                              class="form-control"
                              placeholder="Hi, Do you have a moment to talk Joe?"
                              aria-label="Hi, Do you have a moment to talk Joe?"
                              aria-describedby="basic-icon-default-message2"
                            ></textarea>
                          </div>
                        </div>
                        <div class="mb-3">
                        <label for="formFile" class="form-label">Zip Code:</label>
                        <input class="form-control" type="number" value="18" id="" placeholder="Enter Zip Code" />
                      </div>
                      <div class="mb-3">
                        <label for="formFile" class="form-label">Profile Image:</label>
                        <input class="form-control" type="file" id="formFile" />
                      </div>
                        <button type="submit" class="btn btn-primary">Reset</button>
                            <button type="submit" class="btn btn-success">Submit</button>
                      </form>
                    </div>
                  </div>
                </div>
                <div class="col-xl">
                  <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                      <h5 class="mb-0">Update Bank Details</h5>
                      <small class="text-muted float-end"></small>
                    </div>
                    <div class="card-body">
                      <form>
                        <div class="mb-3">
                          <label class="form-label" for="basic-icon-default-fullname">Bank Name*</label>
                          <div class="input-group input-group-merge">
                          <span id="basic-icon-default-bank2" class="input-group-text"
                              ><i class="bx bx-buildings"></i
                            ></span>
                            <input
                              type="text"
                              class="form-control"
                              id="basic-icon-default-fullname"
                              placeholder="xyz Bank"
                              aria-label="xyz Bank"
                              aria-describedby="basic-icon-default-fullname2"
                            />
                          </div>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="basic-icon-default-company">Bank District*</label>
                          <div class="input-group input-group-merge">
                            <span id="basic-icon-default-company2" class="input-group-text"
                              ><i class="bx bx-buildings"></i
                            ></span>
                            <input
                              type="text"
                              id="basic-icon-default-company"
                              class="form-control"
                              placeholder="ACME Inc."
                              aria-label="ACME Inc."
                              aria-describedby="basic-icon-default-company2"
                            />
                          </div>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="basic-icon-default-email">Bank IFSC: *</label>
                          <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                            <input
                              type="text"
                              id="basic-icon-default-email"
                              class="form-control"
                              placeholder="xxxxxxxx345"
                              aria-label="xxxxxxxx345"
                              aria-describedby="basic-icon-default-email2"
                            />
                        </div>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="basic-icon-default-email">Bank Branch:*</label>
                          <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="bx bx-buildings"></i
                            ></span>
                            <input
                              type="text"
                              id="basic-icon-default-email"
                              class="form-control"
                              placeholder="bank branch 123"
                              aria-label="bank branch 123"
                              aria-describedby="basic-icon-default-email2"
                            />
                        </div>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="basic-icon-default-email">Bank Address: *</label>
                          <div class="input-group input-group-merge">
                          <span id="basic-icon-default-company2" class="input-group-text"
                              ><i class="bx bx-buildings"></i
                            ></span>
                            <input
                              type="text"
                              id="basic-icon-default-email"
                              class="form-control"
                              placeholder="Lane 2/Street A2"
                              aria-label="Lane 2/Street A2"
                              aria-describedby="basic-icon-default-email2"
                            />
                        </div>
                        </div>

                        <div class="mb-3">
                          <label class="form-label" for="basic-icon-default-email">Account Number: *</label>
                          <div class="input-group input-group-merge">
                          <span id="basic-icon-default-company2" class="input-group-text"
                              ><i class="bx bx-buildings"></i
                            ></span>
                            <input
                              type="text"
                              id="basic-icon-default-email"
                              class="form-control"
                              placeholder="xxxxxxxx5677"
                              aria-label="xxxxxxxx5677"
                              aria-describedby="basic-icon-default-email2"
                            />
                        </div>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="basic-icon-default-email">Account Holder Name: *</label>
                          <div class="input-group input-group-merge">
                          <span id="basic-icon-default-company2" class="input-group-text"
                              ><i class="bx bx-buildings"></i></span>
                            <input
                              type="text"
                              id="basic-icon-default-name"
                              class="form-control"
                              placeholder="John Doe"
                              aria-label="John Doe"
                              aria-describedby="basic-icon-default-email2"
                            />
                        </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Reset</button>
                            <button type="submit" class="btn btn-success">Submit</button>
                      </form>
                    </div>
                  </div>
                </div>
              <!-- Basic with Icons -->
              <div class="col-xxl">
                  <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                      <h5 class="mb-0">Update Documents</h5>
                      <small class="text-muted float-end"></small>
                    </div>
                    <div class="card-body">
                      <form>
                      <div class="mb-3">
                        <label for="formFile" class="form-label">Adhar Card:</label>
                        <input class="form-control" type="file" id="formFile" />
                      </div>
                      <div class="mb-3">
                        <label for="formFile" class="form-label">Pan Card:</label>
                        <input class="form-control" type="file" id="formFile" />
                      </div>
                      <div class="mb-3">
                        <label for="formFile" class="form-label">GST Number:</label>
                        <input class="form-control" type="file" id="formFile"/>
                      </div>
                      <div class="mb-3">
                        <label for="formFile" class="form-label">Shop Act Number:</label>
                        <input class="form-control" type="file" id="formFile" />
                      </div>
                      <div class="mb-3">
                        <label for="formFile" class="form-label">Cancelled Cheque:</label>
                        <input class="form-control" type="file" id="formFile" />
                      </div>
                        <div class="row justify-content-end">
                          <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Reset</button>
                            <button type="submit" class="btn btn-success">Submit</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--/ Content-->
            <!-- Footer -->
            <footer class="default-footer">
            @include('includes.footer')
            <!-- / Footer -->
            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper-->
        </div>
        <!-- / Layout page -->
      </div>
      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->
    @include('includes.footer_script')
   <!-- footerscrit -->
  </body>
</html>
 