var final_speech_text = '';
var recognizing = false;

if ('webkitSpeechRecognition' in window) {

  var recognition = new webkitSpeechRecognition();
  recognition.continuous = false;
  recognition.interimResults = false;

  recognition.onerror = function(event) {
    recognition.stop();
  };

  recognition.onresult = function(event) {
    final_speech_text = event.results[0][0].transcript;
	document.getElementById('searchText').value = final_speech_text;
	document.getElementById('frmSearch').submit();
  };
}

function startDictation(event) {
  if (recognizing) {
    recognition.stop();
    return;
  }
  final_speech_text = '';
  recognition.lang = 'en-US';
  recognition.start();
}