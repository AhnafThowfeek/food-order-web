console.log("script working");
const addCloseOpenForm = () => {
    console.log("script working");
    const addFoodOpenButton = document.getElementById("btn-add");
    const addUserRoleOpenButton = document.getElementById("btn-add-role");
    const addUserRoleCloseButton = document.getElementById("btn-x-role");
    const addFoodCloseButton = document.getElementById("btn-x");
    const addFoodForm = document.getElementsByClassName("add-container")[0];
    const addUserRoleForm = document.getElementsByClassName("add-container-role")[0];
    addFoodOpenButton.addEventListener("click", ()=>{
        addFoodForm.style.display = "flex";
    });
    addFoodCloseButton.addEventListener("click", ()=>{
        addFoodForm.style.display = "none";
    });
    addUserRoleOpenButton.addEventListener("click", ()=>{
        addUserRoleForm.style.display = "flex";
    });
    addUserRoleCloseButton.addEventListener("click", ()=>{
        addUserRoleForm.style.display = "none";
    });
}
addCloseOpenForm();

function confirmOrder(id) {
    console.log(id);
    
    // Create a FormData object
    let formData = new FormData();
    formData.append('req', 'confirm');
    formData.append('id', id);

    fetch("admin/controlles/crud_pre_order.php", {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        location.reload();
    })
    .catch(error => console.error('Error:', error));
}
function cancelOrder(id) {
    console.log(id);
    
    // Create a FormData object
    let formData = new FormData();
    formData.append('req', 'cancel');
    formData.append('id', id);

    fetch("admin/controlles/crud_pre_order.php", {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        location.reload();
    })
    .catch(error => console.error('Error:', error));
}
function editOrder(id) {
    console.log(id);
}
function deleteOrder(id) {
    console.log(id);
}
function availableFood(id) {
    console.log(id);
    
    // Create a FormData object
    let formData = new FormData();
    formData.append('req', 'available');
    formData.append('id', id);

    fetch("admin/controlles/crud_foods.php", {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        location.reload();
    })
    .catch(error => console.error('Error:', error));
}
