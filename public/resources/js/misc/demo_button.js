//REM: Helper function to update output area
function updateOutput(message) {
    document.getElementById('outputText').textContent = message;
}

//REM: Dropdown event
document.getElementById('dropdown').addEventListener('change', function() {
    let selected = this.value || 'None';
    updateOutput('Dropdown selected: ' + selected);
});

//REM: Spinner event (using 'input' for realtime updates)
document.getElementById('spinner').addEventListener('input', function() {
    updateOutput('Spinner value: ' + this.value);
});

// //REM: Checkboxes event
// const checkboxes = document.querySelectorAll('input[type="checkbox"][id^="checkbox"]');
// checkboxes.forEach(function(checkbox) {
//     checkbox.addEventListener('change', function() {
//         const checkedValues = Array.from(checkboxes)
//             .filter(cb => cb.checked)
//             .map(cb => cb.value);
//         updateOutput('Checkboxes selected: ' + (checkedValues.join(', ') || 'None'));
//     });
// });

//REM: ES5 version for checkbox event handling
var checkboxes = document.querySelectorAll('input[type="checkbox"][id^="checkbox"]');

for (var i = 0; i < checkboxes.length; i++) {
    checkboxes[i].addEventListener('change', function() {
        var checkedValues = [];
        for (var j = 0; j < checkboxes.length; j++) {
            if (checkboxes[j].checked) {
                checkedValues.push(checkboxes[j].value);
            }
        }
        updateOutput('Checkboxes selected: ' + (checkedValues.join(', ') || 'None'));
    });
}

//REM: Radio buttons event
const radios = document.querySelectorAll('input[name="radiogroup"]');
radios.forEach(function(radio) {
    radio.addEventListener('change', function() {
        if (this.checked) {
            updateOutput('Radio selected: ' + this.value);
        }
    });
});

//REM: Toggle event
document.getElementById('toggle').addEventListener('change', function() {
    let state = this.checked ? 'ON' : 'OFF';
    updateOutput('Toggle is: ' + state);
});

//REM: Image button click event
document.getElementById('imageButton').addEventListener('click', function() {
    alert('Image Button clicked!');
});