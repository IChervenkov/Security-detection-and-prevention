const dropArea = document.getElementById("drag-area");
dragText = document.getElementById("text");

input = document.getElementById("fileToUpload");
let file;

var validFileType = true;
var validFileSize = true;
var validFileName = true;

const maxCount = 20;

input.addEventListener("change", function () {
    var size = input.files.length;
    if(size > maxCount){
		size = maxCount;
	}
    for (var i = 0; i < size; i++) {
        file = input.files[i];
        validate();
    }
});

//Drag file over DropArea
dropArea.addEventListener("dragover", (event) => {
    event.preventDefault(); //preventing from default behaviour
    dragText.textContent = "Release to Upload File";
});

//If dragged file leaves DropArea
dropArea.addEventListener("dragleave", () => {
    dragText.textContent = "Drag & Drop to Upload File";
});

//Drop file on DropArea
dropArea.addEventListener("drop", (event) => {
    event.preventDefault();

    var size = event.dataTransfer.files.length;
	if(size > maxCount){
		size = maxCount;
	}
	
    const dT = new DataTransfer();
	
    for (var i = 0; i < size; i++) {
        file = event.dataTransfer.files[i];
		validate();
		if(validFileType && validFileSize && validFileName){
		
		dT.items.add(event.dataTransfer.files[i]);
		fileToUpload.files = dT.files;
        }
    }
});

function validate() {
    validFileType = true;
    validFileSize = true;
    validFileName = true;

    // file type validation
    var fileType = file.type;
    var allowedExtensions = ["image/jpeg", "image/jpg", "image/png", "image/gif", "text/html", "text/javascript", "text/css"];
    if (!allowedExtensions.includes(fileType)) {
        validFileType = false;
        alert(file.name + " File type is not valid");
    }
    
    // file size validation
    const maxSize = 4096; // 4MB
    const fileSize = Math.round((file.size / 1024));
    if (fileSize > maxSize) {
        validFileSize = false;
        alert(file.name + " File size is not valid");
    }
  
    // file name length validation
    const maxFileNameLength = 20;
    var fileNameLength = file.name.length;
    if (fileNameLength > maxFileNameLength) {
        validFileName = false;
        alert(file.name + " File name is not valid");
    }

}


