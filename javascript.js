document.getElementById("startBtn").addEventListener("click", function() {
  alert("Let's get started with your classes!");
});

document.getElementById("playBtn").addEventListener("click", function() {
  alert("Play the intro video!");
});

document.getElementById("yourFormId").addEventListener("submit", function (event) {
  event.preventDefault(); // prevent actual form submission

  const name = document.getElementById("name").value; // adjust the ID as per your form
  sessionStorage.setItem("userName", name);

  // optionally: you could validate user credentials here

  window.location.href = "Index.html";
});


