// dropdown
function Dropdown() {
    var drop = document.getElementById('dropdown1');
    var Parent = document.getElementById('line');
    
    drop.style.transition = '300ms';
    if (drop.style.left === '-30vw') {
        drop.style.left = '0vw';
        Parent.style.position = 'absolute';
    } else {
        drop.style.left = '-30vw';
        Parent.style.position = 'relative';
    }
}

function Dropdown2() {
    //user logo dropdown
    var drp = document.getElementById('dropdown2');

    drp.style.transition = '300ms';
    drp.style.pointerEvents = 'none';
    if (drp.style.opacity === '0') {
        drp.style.opacity = '100';
        drp.style.pointerEvents = 'auto';
    } else {
        drp.style.opacity = '0';
        drp.style.pointerEvents = 'none';
    }
}

//Light AND Dark MODE ----------------------------------------------------------------------------------------------------------------------------------------------------------------
function Lightmode() {
    const root = document.querySelector(':root');
    var modes = document.getElementById("Lightmode");
    modes.innerHTML = "Toggle Light Mode <i id='BrightIcon' class='fas fa-sun'></i>";

    // set css variable
    root.style.setProperty('--RGB-0', 'rgb(255, 255, 255)');
    root.style.setProperty('--RGB-10', 'rgb(250, 250, 250)');
    root.style.setProperty('--RGB-15', 'rgb(240, 240, 240)');
    root.style.setProperty('--RGB-20', 'rgb(220, 220, 220)');
    root.style.setProperty('--RGB-35', 'rgb(215, 215, 215)');
    root.style.setProperty('--RGB-60', 'rgb(200, 200, 200)');
    root.style.setProperty('--RGB-80', 'rgb(180, 180, 180)');
    root.style.setProperty('--RGB-100', 'rgb(150, 150, 150)');
    root.style.setProperty('--RGB-120', 'rgb(120, 120, 120)');
    root.style.setProperty('--RGB-150', 'rgb(100, 100, 100)');
    root.style.setProperty('--RGB-180', 'rgb(80, 80, 80)');
    root.style.setProperty('--RGB-200', 'rgb(60, 60, 60)');
    root.style.setProperty('--RGB-215', 'rgb(35, 35, 35)');
    root.style.setProperty('--RGB-220', 'rgb(20, 20, 20)');
    root.style.setProperty('--RGB-240', 'rgb(15, 15, 15)');
    root.style.setProperty('--RGB-250', 'rgb(10, 10, 10)');
    root.style.setProperty('--RGB-255', 'rgb(0, 0, 0)');
}
function Darkmode() {
    const root = document.querySelector(':root');
    var modes = document.getElementById("Lightmode");
    modes.innerHTML = "Toggle Dark Mode <i id='BrightIcon' class='fas fa-moon'></i>";

    // set css variable
    root.style.setProperty('--RGB-0', 'rgb(0, 0, 0)');
    root.style.setProperty('--RGB-10', 'rgb(10, 10, 10)');
    root.style.setProperty('--RGB-15', 'rgb(15, 15, 15)');
    root.style.setProperty('--RGB-20', 'rgb(20, 20, 20)');
    root.style.setProperty('--RGB-35', 'rgb(35, 35, 35)');
    root.style.setProperty('--RGB-60', 'rgb(60, 60, 60)');
    root.style.setProperty('--RGB-80', 'rgb(80, 80, 80)');
    root.style.setProperty('--RGB-100', 'rgb(100, 100, 100)');
    root.style.setProperty('--RGB-120', 'rgb(120, 120, 120)');
    root.style.setProperty('--RGB-150', 'rgb(150, 150, 150)');
    root.style.setProperty('--RGB-180', 'rgb(180, 180, 180)');
    root.style.setProperty('--RGB-200', 'rgb(200, 200, 200)');
    root.style.setProperty('--RGB-215', 'rgb(215, 215, 215)');
    root.style.setProperty('--RGB-220', 'rgb(220, 220, 220)');
    root.style.setProperty('--RGB-240', 'rgb(240, 240, 240)');
    root.style.setProperty('--RGB-250', 'rgb(250, 250, 250)');
    root.style.setProperty('--RGB-255', 'rgb(255, 255, 255)');
}

// Searching


//Start up ----------------------------------------------------------------------------------------------------------------------------------------------------------------
window.onload=function(){
    //Starndarts
    Dropdown();
    Dropdown2();
    //silde
    // document.getElementById("main-banner").onmouseenter = function() {
    //     clearInterval(startLoop);
    // }
    // document.getElementById("main-banner").onmouseleave = function() {
    //     startLoop = setInterval(function() {
    //     bannerLoop();
    // }, 4000);
    // }
}

