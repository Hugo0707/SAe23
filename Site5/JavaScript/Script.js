function toggleButton() {
    var manager = document.getElementById("manager");
    var admin = document.getElementById("admin");
    var toggleSwitch = document.querySelector(".toggle-switch-input");
    
    if (toggleSwitch.checked) {
      manager.classList.remove("bold");
      admin.classList.add("bold");
    } else {
      manager.classList.add("bold");
      admin.classList.remove("bold");
    }
  }
  
  