<?php
$simple_string = $user_id; //$_GET['id'];
                                                                    
// Store the cipher method
$ciphering = "AES-256-CTR";
                                                                       
// Use OpenSSl Encryption method
$iv_length = openssl_cipher_iv_length($ciphering);
$options = 0;
                                                                       
// Non-NULL Initialization Vector for encryption
$encryption_iv = '1234567891011121';
                                                                       
// Store the encryption key
$encryption_key = "Seait123";
                                                                       
// Use openssl_encrypt() function to encrypt the data
$encrypted_id = openssl_encrypt($simple_string, $ciphering, $encryption_key, $options, $encryption_iv);

                                                                       
// Non-NULL Initialization Vector for decryption
$decryption_iv = '1234567891011121';
                                                                       
// Store the decryption key
$decryption_key = "Seait123";
                                                                       
// Use openssl_decrypt() function to decrypt the data
$decrypted_id =openssl_decrypt ($simple_string, $ciphering, $decryption_key, $options, $decryption_iv);

$eeid = $encrypted_id;

?>
<div class="sidebar">
  <div class="sidebar-inner">
    <!-- ### $Sidebar Header ### -->
    <div class="sidebar-logo">
      <div class="peers ai-c fxw-nw">
        <div class="peer peer-greed">
          <a class="sidebar-link td-n" href="index.html">
            <div class="peers ai-c fxw-nw">
              <div class="peer">
                <div class="logo">
                  <center><img src="../images/seait.png" alt="" style="width: 50px; height: 50px; padding: 4px; margin-top: 6%;"></center>
                </div>
              </div>
              <div class="peer peer-greed">
                <h5 class="lh-1 mB-0 logo-text">SEAIT-STEP</h5>
              </div>
            </div>
          </a>
        </div>
        <div class="peer">
          <div class="mobile-toggle sidebar-toggle">
            <a href="" class="td-n">
              <i class="ti-arrow-circle-left"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
    <!-- ### $Sidebar Menu ### -->
    <ul class="sidebar-menu scrollable pos-r">
      <li class="nav-item">
        <a class="sidebar-link" href="index.php">
          <span class="icon-holder">
            <i class="c-red-500 ti-files"></i>
          </span>
          <span class="title">Subjects</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="sidebar-link" href="peertopeer.php">
          <span class="icon-holder">
            <i class="c-green-500 ti-layers"></i>
          </span>
          <span class="title">Peer-to-Peer</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="sidebar-link" href="evaluation_result.php">
          <span class="icon-holder">
            <i class="c-blue-500 ti-pie-chart"></i>
          </span>
          <span class="title">Student Evaluations</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="sidebar-link" href="h2f_evaluation_result.php?id=<?php echo $eeid; ?>">
          <span class="icon-holder">
            <i class="c-orange-500 ti-bar-chart"></i>
          </span>
          <span class="title">Heads Evaluation</span>
        </a>
      </li>
    </ul>


  </div>
</div>