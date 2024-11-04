<?php
include('../dbconnection.php');
include('../session.php');
include('admin_session.php');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
  <title>Dashboard</title>
  <style>
    #loader {
      transition: all 0.3s ease-in-out;
      opacity: 1;
      visibility: visible;
      position: fixed;
      height: 100vh;
      width: 100%;
      background: #fff;
      z-index: 90000;
    }

    #loader.fadeOut {
      opacity: 0;
      visibility: hidden;
    }



    .spinner {
      width: 40px;
      height: 40px;
      position: absolute;
      top: calc(50% - 20px);
      left: calc(50% - 20px);
      background-color: #333;
      border-radius: 100%;
      -webkit-animation: sk-scaleout 1.0s infinite ease-in-out;
      animation: sk-scaleout 1.0s infinite ease-in-out;
    }

    @-webkit-keyframes sk-scaleout {
      0% { -webkit-transform: scale(0) }
      100% {
        -webkit-transform: scale(1.0);
        opacity: 0;
      }
    }

    @keyframes sk-scaleout {
      0% {
        -webkit-transform: scale(0);
        transform: scale(0);
      } 100% {
        -webkit-transform: scale(1.0);
        transform: scale(1.0);
        opacity: 0;
      }
    }
  </style>
  <script defer="defer" src="../assets/main.js"></script></head>
  <body class="app">
    <div id="loader">

      <div class="spinner">
      </div>
    </div>

    <script>
      window.addEventListener('load', function load() {
        const loader = document.getElementById('loader');
        setTimeout(function() {
          loader.classList.add('fadeOut');
        }, 2000);
      });
    </script>

    
    
    <div>

      <?php 
      include('sidebar.php'); 
      ?>


      <div class="page-container">
        <!-- ### $Topbar ### -->
        <?php include('navbar.php'); ?>

        <!-- ### $App Screen Content ### -->
        <main class="main-content bgc-grey-100">
          <div id="mainContent">
            <div class="row gap-20 masonry pos-r">
              <div class="masonry-sizer col-md-6"></div>
            
              <div class="masonry-item col-md-12">
                <div class="bgc-white p-20 bd">
                  <h6 class="c-grey-900">SEAIT-Student Teachers Evaluation Program</h6>
                  <div class="mT-30">
                    <div class="peers mT-20 fxw-nw@lg+ jc-sb ta-c gap-10">
                      <div class="peer">
                        <div class="easy-pie-chart" data-size="80" data-percent="75" data-bar-color="#f44336">
                          <span></span>
                        </div>
                        <h6 class="fsz-sm">Admin Users</h6>
                      </div>
                      <div class="peer">
                        <div class="easy-pie-chart" data-size="80" data-percent="50" data-bar-color="#2196f3">
                          <span></span>
                        </div>
                        <h6 class="fsz-sm">Students</h6>
                      </div>
                      <div class="peer">
                        <div class="easy-pie-chart" data-size="80" data-percent="65" data-bar-color="#f44336">
                          <span></span>
                        </div>
                        <h6 class="fsz-sm">Faculty</h6>
                      </div>
                      <div class="peer">
                        <div class="easy-pie-chart" data-size="80" data-percent="90" data-bar-color="#ff9800">
                          <span></span>
                        </div>
                        <h6 class="fsz-sm">Total Evaluations</h6>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
        
              
              <div class="masonry-item col-md-6">
                <!-- #Weather ==================== -->
                <div class="bd bgc-white p-20">
                  <div class="layers">
                    
                    <div class="layer w-100 mB-20">
                      <h6 class="lh-1">Weather</h6>
                    </div>

                    
                    <div class="layer w-100">
                      <div class="peers ai-c jc-sb fxw-nw">
                        <div class="peer peer-greed">
                          <div class="layers">
                            
                            <div class="layer w-100">
                              <div class="peers fxw-nw ai-c">
                                <div class="peer mR-20">
                                  <h3>32<sup>°F</sup></h3>
                                </div>
                                <div class="peer">
                                  <canvas class="sleet" width="44" height="44"></canvas>
                                </div>
                              </div>
                            </div>

                            
                            <div class="layer w-100">
                              <span class="fw-600 c-grey-600">Partly Clouds</span>
                            </div>
                          </div>
                        </div>
                        <div class="peer">
                          <div class="layers ai-fe">
                            <div class="layer">
                              <h5 class="mB-5">Monday</h5>
                            </div>
                            <div class="layer">
                              <span class="fw-600 c-grey-600">Nov, 01 2017</span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    
                    <div class="layer w-100 mY-30">
                      <div class="layers bdB">
                        <div class="layer w-100 bdT pY-5">
                          <div class="peers ai-c jc-sb fxw-nw">
                            <div class="peer">
                              <span>Wind</span>
                            </div>
                            <div class="peer ta-r">
                              <span class="fw-600 c-grey-800">10km/h</span>
                            </div>
                          </div>
                        </div>
                        <div class="layer w-100 bdT pY-5">
                          <div class="peers ai-c jc-sb fxw-nw">
                            <div class="peer">
                              <span>Sunrise</span>
                            </div>
                            <div class="peer ta-r">
                              <span class="fw-600 c-grey-800">05:00 AM</span>
                            </div>
                          </div>
                        </div>
                        <div class="layer w-100 bdT pY-5">
                          <div class="peers ai-c jc-sb fxw-nw">
                            <div class="peer">
                              <span>Pressure</span>
                            </div>
                            <div class="peer ta-r">
                              <span class="fw-600 c-grey-800">1B</span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    
                    <div class="layer w-100">
                      <div class="peers peers-greed ai-fs ta-c">
                        <div class="peer">
                          <h6 class="mB-10">MON</h6>
                          <canvas class="sleet" width="30" height="30"></canvas>
                          <span class="d-b fw-600">32<sup>°F</sup></span>
                        </div>
                        <div class="peer">
                          <h6 class="mB-10">TUE</h6>
                          <canvas class="clear-day" width="30" height="30"></canvas>
                          <span class="d-b fw-600">30<sup>°F</sup></span>
                        </div>
                        <div class="peer">
                          <h6 class="mB-10">WED</h6>
                          <canvas class="partly-cloudy-day" width="30" height="30"></canvas>
                          <span class="d-b fw-600">28<sup>°F</sup></span>
                        </div>
                        <div class="peer">
                          <h6 class="mB-10">THR</h6>
                          <canvas class="cloudy" width="30" height="30"></canvas>
                          <span class="d-b fw-600">32<sup>°F</sup></span>
                        </div>
                        <div class="peer">
                          <h6 class="mB-10">FRI</h6>
                          <canvas class="snow" width="30" height="30"></canvas>
                          <span class="d-b fw-600">24<sup>°F</sup></span>
                        </div>
                        <div class="peer">
                          <h6 class="mB-10">SAT</h6>
                          <canvas class="wind" width="30" height="30"></canvas>
                          <span class="d-b fw-600">28<sup>°F</sup></span>
                        </div>
                        <div class="peer">
                          <h6 class="mB-10">SUN</h6>
                          <canvas class="sleet" width="30" height="30"></canvas>
                          <span class="d-b fw-600">32<sup>°F</sup></span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="masonry-item col-md-6">
                <!-- #Weather ==================== -->
                <div class="bd bgc-white p-20">
                  <div class="layers">
                            <div class="layer w-100">
                              <h5 class="mB-5">Picture Here</h5>
                              <small class="fw-600 c-grey-700">Instructor Name Here</small>
                              <span class="pull-right c-grey-600 fsz-sm">50%</span>
                              <div class="progress mT-10">
                                <div class="progress-bar bgc-deep-purple-500" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:50%;"> <span class="visually-hidden">50% Complete</span></div>
                              </div>
                              <div class="layer w-100">
                        <div class="peers">
                            <span id="sparklinedash"></span>

                        
                        </div>
                      </div>
                            </div>
                            
                           
                          </div>
                </div>
              </div>
             
            </div>
          </div>
        </main>

        <!-- ### $App Screen Footer ### -->
        <?php include('footer.php'); ?>
      </div>
    </div>
  </body>
  </html>
