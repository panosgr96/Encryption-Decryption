function byteArrayToHex(byteArray) {
  var result = "";
  if (!byteArray)
    return;
  for (var i=0; i<byteArray.length; i++)
    result += ((byteArray[i]<16) ? "0" : "") + byteArray[i].toString(16);

  return result;
}

function hex2s(hex)
{
  var r='';
  if(hex.indexOf("0x") == 0 || hex.indexOf("0X") == 0) hex = hex.substr(2);

  if(hex.length%2) hex+='0';

  for(var i = 0; i<hex.length; i += 2)
    r += String.fromCharCode(parseInt(hex.slice(i, i+2), 16));
  return r;
}

function formatPlaintext(plaintext) {
  var bpb = blockSizeInBits / 8;               // bytes per block
  var i;

  // if primitive string or String instance
  if (typeof plaintext == "string" || plaintext.indexOf) {
    plaintext = plaintext.split("");
    // Unicode issues here (ignoring high byte)
    for (i=0; i<plaintext.length; i++)
      plaintext[i] = plaintext[i].charCodeAt(0) & 0xFF;
  } 

  for (i = bpb - (plaintext.length % bpb); i > 0 && i < bpb; i--) 
    plaintext[plaintext.length] = 0;
  
  return plaintext;
}

function getRandomBytes(howMany) {
  var i;
  var bytes = new Array();
  for (i=0; i<howMany; i++)
    bytes[i] = Math.round(Math.random()*255);
  return bytes;
}

function aesEncrypt(plaintext, key, mode) {
  var i, aBlock;
  var bpb = blockSizeInBits / 8;          // bytes per block
  var ct;                                 // ciphertext

  if (!plaintext || !key)
    return;
  if (key.length*8 != keySizeInBits)
    return; 
  if (mode == "CBC")
    ct = getRandomBytes(bpb);             // get IV
  else {
    mode = "ECB";
    ct = new Array();
  }

  // convert plaintext to byte array and pad with zeros if necessary. 
  plaintext = formatPlaintext(plaintext);

  var expandedKey = new keyExpansion(key);
  
  for (var block=0; block<plaintext.length / bpb; block++) {
    aBlock = plaintext.slice(block*bpb, (block+1)*bpb);
    if (mode == "CBC")
      for (var i=0; i<bpb; i++) 
        aBlock[i] ^= ct[block*bpb + i];
    ct = ct.concat(AESencrypt(aBlock, expandedKey));
  }

  return ct;
}

function aesDecrypt(ciphertext, key, mode) {
  var bpb = blockSizeInBits / 8;          // bytes per block
  var pt = new Array();                   // plaintext array
  var aBlock;                             // a decrypted block
  var block;                              // current block number

  if (!ciphertext || !key) return;
  if(typeof ciphertext == "string")
  {
    ciphertext = ciphertext.split("");
    for (i=0; i<ciphertext.length; i++)
      ciphertext[i] = ciphertext[i].charCodeAt(0) & 0xFF;
  }

 if (key.length*8 != keySizeInBits)
    return; 
  if (!mode)
    mode = "ECB";                         // assume ECB if mode omitted

  var expandedKey = new prepare_decryption(key);
 
  // work backwards to accomodate CBC mode 
  for (block=(ciphertext.length / bpb)-1; block>0; block--) {
    aBlock = 
     AESdecrypt(ciphertext.slice(block*bpb,(block+1)*bpb), expandedKey);
    if (mode == "CBC") 
      for (var i=0; i<bpb; i++) 
        pt[(block-1)*bpb + i] = aBlock[i] ^ ciphertext[(block-1)*bpb + i];
    else 
      pt = aBlock.concat(pt);
  }

  // do last block if ECB (skips the IV in CBC)
  if (mode == "ECB")
    pt = AESdecrypt(ciphertext.slice(0, bpb), expandedKey).concat(pt);

  return pt;
}
