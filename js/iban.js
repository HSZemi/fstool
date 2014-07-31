function toggleIban(){
	if(ibanlocked){
		ibanpassword = window.prompt("Bitte das Passwort zur Entschlüsselung eingeben:","");
		var decryptionerror = false;
		
		$('.iban').each(function(i, obj){
			ciphertext = $(this).val();
			if(ciphertext != ""){
				plaintext = CryptoJS.AES.decrypt(ciphertext, ibanpassword);
				if(plaintext == ""){
					decryptionerror = true;
				} else {
					$(this).val(backToString(plaintext));
				}
			}
			
		});
		if(!decryptionerror){
			$('.iban').each(function(i, obj){
				$(this).prop('readonly', false);
			});
		}

			if(decryptionerror){
			alert("Fehler beim Entschlüsseln! Falsches Passwort?");
		} else {
			ibanlocked = false;
			$('#ibanbutton').html('IBAN: <span class="glyphicon glyphicon-pencil"></span>');
			$('#ibanbutton').addClass('btn-danger');
		}
	} else {
		$('.iban').each(function(i, obj){
			plaintext = $(this).val();
			if(plaintext != ""){
				$(this).val(CryptoJS.AES.encrypt(plaintext, ibanpassword));
			}
			$(this).prop('readonly', true);
		});
		
		ibanlocked = true;
		$('#ibanbutton').html('IBAN: <span class="glyphicon glyphicon-lock"></span>');
		$('#ibanbutton').removeClass('btn-danger');
	}

}

function decryptIban(){
	ibanpassword = window.prompt("Bitte das Passwort zur Entschlüsselung eingeben:","");
	var decryptionerror = false;
	
	$('.iban').each(function(i, obj){
		ciphertext = $(this).text();
		if(ciphertext != ""){
			plaintext = CryptoJS.AES.decrypt(ciphertext, ibanpassword);
			if(plaintext == ""){
				decryptionerror = true;
			} else {
				$(this).text(backToString(plaintext));
			}
		}
		
	});

	if(decryptionerror){
		alert("Fehler beim Entschlüsseln! Falsches Passwort?");
	} else {
		$('#ibanbutton').remove();
	}
}

	function backToString(input){
	if(input == ""){
		return "";
	} else {
		items = (""+input).split("");
		if(items.length % 2 > 0){
			return "";
		}
		s = "";
		for(i=0;i<(items.length);i=i+2){
			s=s+String.fromCharCode(parseInt(items[i]+items[i+1], 16));
		}
		return s;
	}
}