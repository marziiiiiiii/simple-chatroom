const msgerForm = get('.msger-inputarea');
const msgerInput = get('.msger-input');
const msgerChat = get('.msger-chat');

// const from = get('.myname');
// const fromImg = get('.myavatar');

navigator.mediaDevices.getUserMedia({ audio: true }).then((stream) => {
  handlerFunction(stream);
});

function handlerFunction(stream) {
  rec = new MediaRecorder(stream);
  rec.ondataavailable = (e) => {
    audioChunks.push(e.data);
    if (rec.state == 'inactive') {
      let blob = new Blob(audioChunks, { type: 'audio/mpeg-3' });
      recordedAudio.src = URL.createObjectURL(blob);
      recordedAudio.controls = true;
      recordedAudio.autoplay = true;
      sendData(blob);
    }
  };
}
function sendData(data) {}

// record.onclick = (e) => 
function startRec(){
  console.log('I was clicked');
  startRecord.disabled = true;
  startRecord.style.backgroundColor = 'blue';
  stopRecord.disabled = false;
  audioChunks = [];
  rec.start();
};
// stopRecord.onclick = (e) => 
function stopRec(){
  console.log('I was clicked');
  startRecord.disabled = false;
  stop.disabled = true;
  startRecord.style.backgroundColor = 'red';
  rec.stop();
};
//--------------------------------------------------
// function sendmsg() {
//   event.preventDefault();

//   const msgText = msgerInput.value;
//   if (!msgText) return;
//   appendMessage(from.textContent, fromImg.src, 'right', msgText);
//   msgerInput.value = '';
// }

// function sendvc() {
//   event.preventDefault();
// }

function openHistory(destName) {
  console.log(destName);
  document.cookie = 'dest=' + destName;
  // var objDiv = document.getElementById('history');
  // objDiv.scrollTop = objDiv.scrollHeight;
  location.reload();
}

// msgerForm.addEventListener('submit', (event) => {
//   event.preventDefault();

//   const msgText = msgerInput.value;
//   if (!msgText) return;

//   appendMessage(PERSON_NAME, PERSON_IMG, 'right', msgText);
//   msgerInput.value = '';

//   botResponse();
// });

// Utils
// function get(selector, root = document) {
//   return root.querySelector(selector);
// }
