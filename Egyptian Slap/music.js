var audioPlayer = document.getElementById("myAudio");
var speakerBtn = document.getElementById("speakerBtn");
audioPlayer.loop = true;
function toggleAudio(){
    if(audioPlayer.paused){
        audioPlayer.play();
        speakerBtn.style.backgroundColor="#333333";
        // Will probably change button img style in future to indicate if its playing or not
    }
    else{
        audioPlayer.pause();
        speakerBtn.style.backgroundColor="grey";
        // Will probably change button img style in future to indicate if its playing or not
    }
}