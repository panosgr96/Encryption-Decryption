<!DOCTYPE html>
<html>
  <head>
    <title>Cryptography project</title>
    <meta charset="UTF-8">
    <meta name="author" content="Panagiotis Stathopoulos">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/mystyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="js/euclides/euclidean_algorithm.js"></script>
    <script type="text/javascript" src="js/vigenere/vigenere.js"></script>
    <script type="text/javascript" src="js/aes/aes-enc.js"></script>
    <script type="text/javascript" src="js/aes/aes-dec.js"></script>
    <script type="text/javascript" src="js/aes/aes-test.js"></script>
    <script type="text/javascript">
      function doEncryption(){
        var pt, key;
        var theForm = document.forms[0];
        blockSizeInBits=128;
        keySizeInBits = 128;

        if (theForm.key.value.toLowerCase().indexOf("0x") == 0)
          theForm.key.value = theForm.key.value.substring(2);
        if (theForm.plaintext.value.toLowerCase().indexOf("0x") == 0)
          theForm.plaintext.value = theForm.plaintext.value.substring(2);
        
        if (theForm.key.value.length*4 != keySizeInBits) {
          alert("For a " + keySizeInBits + " bit key, the hex string needs to be " +
                (keySizeInBits / 4) + " hex characters long."+theForm.key.value.length);
          if (theForm.key.select)
             theForm.key.select();
          return;
        }

        if (theForm.plaintext.value.length*4 != blockSizeInBits) {
          alert("For a " + blockSizeInBits + " bit block, the hex plaintext string needs to be " +
                (blockSizeInBits / 4) + " hex characters long.");
          if (theForm.plaintext.select)
             theForm.plaintext.select();
          return;
        }
           
        pt = hex2s(theForm.plaintext.value);
        key = hex2s(theForm.key.value);
        theForm.ciphertext.value = byteArrayToHex(aesEncrypt(pt, key, "ECB"));
      }

      function doDecryption() {
        var ct, key;
        var theForm = document.forms[0];
        blockSizeInBits=128;
        keySizeInBits = 128;

        if (theForm.key.value.toLowerCase().indexOf("0x") == 0)
          theForm.key.value = theForm.key.value.substring(2);
        if (theForm.ciphertext.value.toLowerCase().indexOf("0x") == 0)
          theForm.ciphertext.value = theForm.ciphertext.value.substring(2);
        
        if (theForm.key.value.length*4 != keySizeInBits) {
          alert("For a " + keySizeInBits + " bit key, the hex string needs to be " +
                (keySizeInBits / 4) + " hex characters long.");
          if (theForm.key.select)
             theForm.key.select();
          return;
        }

        if (theForm.ciphertext.value.length*4 != blockSizeInBits) {
          alert("For a " + blockSizeInBits + " bit block, the hex ciphertext string needs to be " +
                (blockSizeInBits / 4) + " hex characters long.");
          if (theForm.ciphertext.select)
             theForm.ciphertext.select();
          return;
        }
           
        ct = hex2s(theForm.ciphertext.value);
        key = hex2s(theForm.key.value);
        theForm.plaintext.value = byteArrayToHex(aesDecrypt(ct, key, "ECB"));
      }
    </script>
  </head>

  <body class="w3-light-grey">
  
  <header>
    <div class="w3-container w3-blue-grey w3-center w3-xlarge" style="width: 100%">Cryptography Project</div>
  </header>
  
  <!-- Page Container -->
  <div class="w3-content w3-margin-top" style="max-width:1400px;">

    <!-- The Grid -->
    <div class="w3-row-padding">
    
      <!-- Left Column -->
      <div class="w3-third">
      
        <div class="w3-white w3-text-grey w3-card-4">      
          <div class="w3-container">
            <p class="w3-large"><b><i class="fa fa-asterisk fa-fw w3-margin-right w3-text-blue-grey"></i>Student's Card</b></p>

            <p><i class="fa fa-certificate fa-fw w3-margin-right w3-large w3-text-blue-grey"></i>Panagiotis Stathopoulos, e14176</p>
            <p><i class="fa fa-envelope fa-fw w3-margin-right w3-large w3-text-blue-grey"></i>panagiotisstathopoulos1@gmail.com</p>
            <p><i class="fa fa-globe fa-fw w3-margin-right w3-large w3-text-blue-grey"></i>Athens, Greece</p>
            <p><i class="fa fa-home fa-fw w3-margin-right w3-text-blue-grey"></i>University of Piraeus, Digital Systems</b></p>
            <hr>

            <p class="w3-large"><b><i class="fa fa-asterisk fa-fw w3-margin-right w3-text-blue-grey"></i>Assignments</b></p>
            <p>Euclidean Algorithm</p>
            <p>Stream Cipher (Vigenere)</p>
            <p>Block Cipher (AES 128)</p>
          </div>
        </div><br>

      <!-- End Left Column -->
      </div>

      <!-- Right Column -->
      <div class="w3-twothird">
        <button class="w3-container w3-card accordion"><h2 class="w3-text-grey w3-padding-10"><i class="fa fa-asterisk fa-fw w3-margin-right w3-xlarge w3-text-blue-grey"></i>Euclidean Algorithm</h2></button>

        <div class="w3-container w3-card w3-white panel"><br>      
          <div class="floatLeft">
            <div class="floatLeft w3-margin-right">
              <label for="a" class="w3-text-blue-grey">a</label>
              <input type="number" id="a" value="1" />
            </div>

            <div class="floatLeft w3-margin-right">
              <label for="b" class="w3-text-blue-grey">b</label>
              <input type="number" id="b" value="3" />
            </div>

            <br><br>
            <div id="euclResults">
              <div class="floatLeft">
                <label for="x" class="w3-text-grey">x =</label>
                <span class="w3-text-blue-grey" id="x"></span>
              </div> 
              <br>
              <div>
                <label for="y" class="w3-text-grey">y =</label>
                <span class="w3-text-blue-grey" id="y"></span>
              </div>
              <br> 
              <div class="floatLeft">
                <label for="gcd" class="w3-text-grey">gcd(a,b) =</label>
                <span class="w3-text-blue-grey" id="gcd"></span>
              </div>
            </div> 

            <br><br>
            <div class="floatLeft">          
            <input type="button" class="w3-button w3-text-grey" value="Calculate" id="calcEucl"/>
            <input type="reset" class="w3-button w3-text-grey" value="Clear" id="resetEucl"/>
            </div>
          </div>
          
          <br>                                         
        </div>

        <button class="w3-container w3-card accordion "><h2 class="w3-text-grey w3-padding-10"><i class="fa fa-asterisk fa-fw w3-margin-right w3-xlarge w3-text-blue-grey"></i>Stream Cipher (Vigenere)</h2></button>

        <div class="w3-container w3-card w3-white panel"><br>         
            <div class="floatLeft">
              <div>
                  <label for="key" class="w3-text-blue-grey">Key:</label><br>
                  <input type="text" value="abc" id="key"/>
              </div><br>
              <div>
                <label for="text" class="w3-text-blue-grey">Text:</label><br>
                <textarea id="text" cols="80" rows="5" >Blaise de Vigenere</textarea>
              </div>
              <div>
                <input type="button" class="w3-button w3-text-grey" value="Encrypt" onclick="doCrypt(false)"/>
                <input type="button" class="w3-button w3-text-grey" value="Decrypt" onclick="doCrypt(true)"/>
              </div>
            </div>                                                  
        </div>

        <button class="w3-container w3-card accordion "><h2 class="w3-text-grey w3-padding-10"><i class="fa fa-asterisk fa-fw w3-margin-right w3-xlarge w3-text-blue-grey"></i>Block Cipher (AES 128)</h2></button>

        <div class="w3-container w3-card w3-white panel"><br>                
          <form name="aestest">
          <div>
            <div>              
                <label for="key" class="w3-text-blue-grey">Key: </label><br>
                <input type="text" size="66" name="key" value="E8E9EAEBEDEEEFF0F2F3F4F5F7F8F9FA"><br><br>
            </div>
            <div>
                <label for="key" class="w3-text-blue-grey">Text: </label><br>
                <input type="text" size="66" name="plaintext" value="aes - 128 is a strong encryption"><br><br>
            </div>
            <div>
                <label for="key" class="w3-text-blue-grey">Encrypted Text: </label><br>
                <input type="text" size="66" name="ciphertext"><br><br>
            </div>
            <div>                         
              <input type="button" class="w3-button w3-text-grey" value="Encrypt" onclick="doEncryption()">
              <input type="button" class="w3-button w3-text-grey" value="Decrypt" onclick="doDecryption()">
              <input type="reset" class="w3-button w3-text-grey" value="Clear">
            </div>
          </div>
          </form>        
        </div>
      <!-- End Right Column -->
      </div>
      
    <!-- End Grid -->
    </div>
    
    <!-- End Page Container -->
  </div>

  <footer class="w3-container w3-blue-grey w3-center w3-margin-top">
    <p>Developed and Designed by <p> Panagiotis Stathopoulos</p></p>
  </footer>

  <script>                                                                                                                                                                                                                                                    
  var acc = document.getElementsByClassName("accordion");
  var i;

  for (i = 0; i < acc.length; i++) {
    acc[i].onclick = function() {
      this.classList.toggle("active");
      var panel = this.nextElementSibling;
      if (panel.style.maxHeight){
        panel.style.maxHeight = null;
      } else {
        panel.style.maxHeight = panel.scrollHeight + "px";
      } 
    }
  }
  </script>

  </body>
</html>
