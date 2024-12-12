const userid = sessionStorage.getItem('userid');

profile = document.querySelector('.header .flex .profile');

document.querySelector('#user-btn').onclick =() =>{
    profile.classList.toggle('active');
    navbar.classList.remove('active');
  
}

window.onscroll = () =>{
    navbar.classList.remove('active');
    profile.classList.remove('active');
}

function loader(){
    document.querySelector('.loader').style.display = 'none';
}

function fadeOut(){
    setInterval(loader, 2000);
}

window.onload = fadeOut;


const elements = [
    { id: "user-details", redirect: true },
    { id: "orders", redirect: true },
    { id: "customer-name", redirect: false },
    { id: "logout-btn", redirect: false }
];

elements.forEach(element => {
    const el = document.getElementById(element.id);
    if (el) {
        if (userid) {
            console.log("User is already logged in.");
            if (element.id === "logout-btn") {
                el.removeEventListener('click', handleLogout);
                el.addEventListener('click', handleLogout);
            }
        } else {
            el.remove();
            if (element.redirect) {
                window.location.replace("http://localhost/Assignment/client-side/login.html");
            }
        }
    }
});

const loginForm = document.getElementById("login");
if (loginForm) {
    loginForm.onsubmit = async (event) => {
        event.preventDefault();

        const formData = new FormData(loginForm);

        try {
            const response = await fetch("http://localhost/Assignment/server-side/routers/api.php", {
                method: "POST",
                body: formData
            });

            if (response.ok) {
                const data = await response.json();
                if (data.id) {
                    sessionStorage.setItem('userid', data.id);
                    console.log("Login successful. User ID:", data.id);
                    window.location.replace("http://localhost/Assignment/client-side/profile.html");
                } else {
                    console.error("Login failed:", data.message);
                    alert("Login failed: " + data.message);
                }
            } else {
                console.error("Network response was not ok.");
                alert("Network response was not ok.");
            }
            const logoutBtn = document.getElementById("logout-btn");
            if(logoutBtn){
                logoutBtn.removeEventListener('click', handleLogout);
                logoutBtn.addEventListener('click', handleLogout);
            }
        } catch (error) {
            console.error("There was a problem with the fetch operation:", error);
            alert("There was a problem with the fetch operation: " + error.message);
        }
    };
}


document.addEventListener("DOMContentLoaded", () => {
    const boxContainer = document.getElementById("menu-container");

    // Fetch data from the server
    fetch('http://localhost/Assignment/server-side/routers/api.php?req=foods')
        .then(response => response.json())
        .then(data => {
            if (data.success && Array.isArray(data.data)) {
                data.data.forEach(food => {
                    // Create product element
                    const productElement = document.createElement("form");
                    productElement.classList.add("box");
                    productElement.setAttribute("action", "");
                    productElement.setAttribute("method", "post");

                    // Create and append product content
                    productElement.innerHTML = `
                        <button type="submit" class="fas fa-eye" name="quick_view"></button>
                        <button type="submit" class="fa-solid fa-utensils" name="add_to_table"></button>
                        <img src="${food.food_images_path}" alt="${food.food_name}">
                        <a href="#" class="cat">Fast Food</a>
                        <div class="name">${food.food_name}</div>
                        <div class="flex">
                            <div class="price"><span>Rs.</span>${food.full_price}</div>
                            <input type="number" name="qty" class="qty" min="1" max="99" value="1" onkeypress="if(this.value.length == 2) return false;">
                        </div>
                    `;

                    // Append the product element to the container
                    boxContainer.appendChild(productElement);
                });
            } else {
                console.error('Failed to load products');
            }
        })
        .catch(error => console.error('Error fetching data: ', error));
});



document.addEventListener("DOMContentLoaded", () => {
    const boxContainer = document.getElementById("event-container");

    // Fetch data from the server
    fetch('http://localhost/Assignment/server-side/routers/api.php?req=event')
        .then(response => response.json())
        .then(data => {
            if (data.success && Array.isArray(data.data)) {
                data.data.forEach(event => {
                    // Create product element
                    const productElement = document.createElement("form");
                    productElement.classList.add("box");
                    productElement.setAttribute("action", "");
                    productElement.setAttribute("method", "post");

                    // Create and append product content
                    productElement.innerHTML = `
                        <button type="submit" class="fas fa-eye" name="quick_view"></button>
                        <img src="${event.event_photo_path}" alt="${event.details}">
                        <div class="name">${event.title}</div>
                        <div class="name">${event.details}</div>
                       
                    `;

                    // Append the product element to the container
                    boxContainer.appendChild(productElement);
                   
                });
            } else {
                console.error('Failed to load products');
            }
        })
        .catch(error => console.error('Error fetching data: ', error));
});



document.addEventListener("DOMContentLoaded", () => {
    const boxContainer = document.getElementById("promotion-container");

    // Fetch data from the server
    fetch('http://localhost/Assignment/server-side/routers/api.php?req=promotion')
        .then(response => response.json())
        .then(data => {
            if (data.success && Array.isArray(data.data)) {
                data.data.forEach(promotion => {
                    // Create product element
                    const productElement = document.createElement("form");
                    productElement.classList.add("box");
                    productElement.setAttribute("action", "");
                    productElement.setAttribute("method", "post");

                    // Create and append product content
                    productElement.innerHTML = `
                        <button type="submit" class="fas fa-eye" name="quick_view"></button>
                        <img src="${promotion.promotion_photo_path}" alt="${promotion.details}">
                        <div class="name">${promotion.title}</div>
                        <div class="name">${promotion.details}</div>
                       
                    `;

                    // Append the product element to the container
                    boxContainer.appendChild(productElement);
                   
                });
            } else {
                console.error('Failed to load products');
            }
        })
        .catch(error => console.error('Error fetching data: ', error));
});



document.addEventListener("DOMContentLoaded", () => {
    const boxContainer = document.getElementById("table-container");

    // Fetch data from the server
    fetch('http://localhost/Assignment/server-side/routers/api.php?req=table')
        .then(response => response.json())
        .then(data => {
            if (data.success && Array.isArray(data.data)) {
                data.data.forEach(table => {
                    // Create product element
                    const productElement = document.createElement("form");
                    productElement.classList.add("box");
                    productElement.setAttribute("action", "");
                    productElement.setAttribute("method", "post");

                    // Create and append product content
                    productElement.innerHTML = `
                        <button type="submit" class="fas fa-eye" name="quick_view"></button>
                        <img src="${table.table_images_path}" alt="${table.id}">
                        <div class="name">${table.table_no}</div>
                        <div class="name">${table.number_of_seats}</div>
                        <div class="name">${table.is_availabile}</div>
                       
                    `;

                    // Append the product element to the container
                    boxContainer.appendChild(productElement);
                   
                });
            } else {
                console.error('Failed to load products');
            }
        })
        .catch(error => console.error('Error fetching data: ', error));
});

const runUserDataGet = async() => {
    
    const formData = new FormData();
    formData.append("req", "getcustomer");
    formData.append("id", userid);
   
    try {
        const response = await fetch("http://localhost/Assignment/server-side/routers/api.php", {
            method: "POST",
            body: formData
        });

        if (response.ok) {
            const data = await response.json();
            const profileName = document.getElementById("profile-name");
            const profilePhoneNumber = document.getElementById("profile-phone-no");
            const profileEmail = document.getElementById("profile-email");
            const customerName = document.getElementById("customer-name");
            if(profileName && profileEmail && profilePhoneNumber){
                profileName.textContent = data['full_name'];
                profilePhoneNumber.textContent = data['phone_number'];
                profileEmail.textContent = data['email'];
            }
            if(customerName){
                customerName.textContent = data['full_name'];
            }
            
        } else {
            console.error("Network response was not ok.");
            alert("Network response was not ok.");
        }
    } catch (error) {
        console.error("There was a problem with the fetch operation:", error);
        alert("There was a problem with the fetch operation: " + error.message);
    }

    const orderContainer = document.getElementById("order-container");
    const totalPrice = document.getElementById("total-price");
    if(orderContainer){
        const formData = new FormData();
        formData.append("req", "pre_orders");
        formData.append("id", userid);
    
        try {
            const response = await fetch("http://localhost/Assignment/server-side/routers/api.php", {
                method: "POST",
                body: formData
            });

            if (response.ok) {
                const data = await response.json();
                let total = 0;
                if (Array.isArray(data)) {
                    data.forEach(food => {
                        total += parseFloat(food.full_price);
                        // Create product element
                        const productElement = document.createElement("form");
                        productElement.classList.add("box");
                        productElement.setAttribute("action", "");
                        productElement.setAttribute("method", "post");
    
                        // Create and append product content
                        productElement.innerHTML = `
                            <button type="submit" class="fas fa-eye" name="quick_view"></button>
                            <button type="submit" class="fas fa-times" name="delete"></button>
                            <img src="${food.food_images_path}" alt="${food.food_name}">
                            <div class="name">${food.food_name}</div>
                            <div class="flex">
                                <div class="price"><span>Rs.</span>${food.full_price}</div>
                                <input type="number" name="qty" class="qty" min="1" max="99" value="1" onkeypress="if(this.value.length == 2) return false;">
                                <button type="submit" class="fas fa-edit"></button>
                            </div>
                            <div class="sub-total">sub total : <span>${food.full_price}</span></div>
                        `;
    
                        // Append the product element to the container
                        orderContainer.appendChild(productElement);
                    });
                    totalPrice.textContent = `Rs.${total}`
                }
            } else {
                console.error("Network response was not ok.");
                alert("Network response was not ok.");
            }
        } catch (error) {
            console.error("There was a problem with the fetch operation:", error);
            alert("There was a problem with the fetch operation: " + error.message);
        }
    }

}

if(userid){
    runUserDataGet();
}
