<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Text to Speech Example</title>
</head>
<body>
  <h1>Text to Speech Example</h1>
  <textarea id="text-to-read" rows="5" cols="50">Enter text here to be read aloud.</textarea>
  <button onclick="speak()">Speak</button>
  <button onclick="paste()">Paste</button>
  <button onclick="stop()">Stop</button>
  <button onclick="pause()">Pause</button>
  <button onclick="resume()">Resume</button>
  <button onclick="pasteThenSpeak()">Paste & Speak</button>
  
  <label>
    <input type="checkbox" id="repeat-checkbox">
    Repeat
  </label>
  
  <label for="voice-select">Voice:</label>
  <select id="voice-select"></select>

  <script>
    var utterance;
    
    function speak() {
      var text = document.getElementById("text-to-read").value;
      utterance = new SpeechSynthesisUtterance(text);
      if (document.getElementById("repeat-checkbox").checked) {
        utterance.onend = function() {
          speechSynthesis.speak(utterance);
        };
      }
      var voices = speechSynthesis.getVoices();
      var selectedVoice = document.getElementById("voice-select").value;
      for (var i = 0; i < voices.length; i++) {
        if (voices[i].name === selectedVoice) {
          utterance.voice = voices[i];
          break;
        }
      }
      speechSynthesis.speak(utterance);
    }
    
    function populateVoiceList() {
      var voices = speechSynthesis.getVoices();
      var voiceSelect = document.getElementById("voice-select");
      for (var i = 0; i < voices.length; i++) {
        var option = document.createElement("option");
        option.value = voices[i].name;
        option.textContent = voices[i].name + " (" + voices[i].lang + ")";
        if (voices[i].default) {
          option.selected = true;
        }
        voiceSelect.appendChild(option);
      }
    }
    
    function paste() {
      navigator.clipboard.readText().then(function(text) {
        document.getElementById("text-to-read").value = text;
      });
    }
    
    function stop() {
      speechSynthesis.cancel();
    }
    
    function pause() {
      speechSynthesis.pause();
    }
    
    function resume() {
      speechSynthesis.resume();
    }
		function pasteThenSpeak(){
			stop();
			paste();
			setTimeout(function(){
				speak();
			}, 100);
		}
    
    populateVoiceList();
    if (speechSynthesis.onvoiceschanged !== undefined) {
      speechSynthesis.onvoiceschanged = populateVoiceList;
    }
  </script>
</body>
</html>
