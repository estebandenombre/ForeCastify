function allowDrop(event) {
    event.preventDefault();
}

function drop(event) {
    event.preventDefault();
    const tableId = event.dataTransfer.getData("text");
    const table = document.getElementById(tableId);
    event.target.appendChild(table);
}

document.addEventListener("dragstart", function(event) {
    event.dataTransfer.setData("text", event.target.id);
});
