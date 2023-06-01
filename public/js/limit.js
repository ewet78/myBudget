const renderInfoBox = (limit, categoryValue) => {
    if (limit === 0){
        limitInfo.textContent = `You do not set the limit for ${categoryValue} category`;
    } else {
        limitInfo.textContent = `You set the limit of ${limit} PLN for ${categoryValue} category`;
    }
}

const renderValueBox = (limitValue, categoryValue) => {
    limitValueForCategory.textContent = `You spent ${limitValue} PLN this month for ${categoryValue} category`;
}

const renderLeftBox = (limitInfoData, monthlyExpenses, amount, category) => {
    const balance = limitInfoData - monthlyExpenses - amount;
    if (limitInfoData === 0) {
        cashLeftForCategory.style.color = "#579BB1";
        cashLeftForCategory.textContent =  `You do not set the limit for ${category} category`;
    } else if (balance < 0) {
        cashLeftForCategory.style.color = "rgb(215, 78, 78)";
        cashLeftForCategory.textContent = `Limit balance after operation: ${balance} PLN`;
    } else if (balance >= 0) {
        cashLeftForCategory.style.color = "#579BB1";
        cashLeftForCategory.textContent = `Limit balance after operation: ${balance} PLN`;
    } 
}


let category = document.querySelector("#kategoria");

let limitInfo = document.querySelector("#limitInfoForCategory");

let date_of_expense = document.querySelector("#date_of_expense");

let limitValueForCategory = document.querySelector("#limitValueForCategory");

let currentAmount = document.querySelector("#amount");

let cashLeftForCategory = document.querySelector("#cashLeftForCategory");

const getLimitForCategory = async (category) => {
    try {
        category = category.replace(/\s+/g, '-');
        const res = await fetch(`../api/limit/${category}`);
        const data = await res.json();
        return data;
    } catch (e){
        console.log('ERROR: ', e);
    }
}

const getLimitValueForCategory = async (category, date) => {
    try {
        category = category.replace(/\s+/g, '-');
        const res = await fetch(`../api/limitvalue/${category}?date_of_expense=${date}`);
        const data = await res.json();
        return data;
    } catch (e){
        console.log('ERROR: ', e);
    }
}

category.addEventListener("change", async (event) => {
    const categoryValue = event.target.value;
    const dateValue = date_of_expense.value;
    if (categoryValue === "--Choose Category--") {
        cashLeftForCategory.textContent = `Category required`;
        limitInfo.textContent = `Category required`;
        limitValueForCategory.textContent = `Category required`;
        return;
      } else {
    
    const limit = await getLimitForCategory(categoryValue);
    let limitValue = await getLimitValueForCategory(categoryValue, dateValue);
    if (limitValue === null) {
        limitValue = 0;
    }
    renderInfoBox(limit, categoryValue);
    renderValueBox(limitValue, categoryValue);

    const amountEvent = new Event("input");
    amount.dispatchEvent(amountEvent);
}
});

date_of_expense.addEventListener("change", async (event) => {
    const categoryValue = category.value;
    if (categoryValue === "--Choose Category--"){
        cashLeftForCategory.textContent = `Category required`;
        limitInfo.textContent = `Category required`;
        limitValueForCategory.textContent = `Category required`;
        return;
    } else {
    const dateValue = event.target.value;
    const limit = await getLimitForCategory(categoryValue);
    let limitValue = await getLimitValueForCategory(categoryValue, dateValue);
    if (limitValue === null) {
        limitValue = 0;
    }
    renderInfoBox(limit, categoryValue);
    renderValueBox(limitValue, categoryValue);
}
});

amount.addEventListener("input", async(event) => {
    const amount = currentAmount.value;
    let categoryValue = category.value;
    let dateValue = date_of_expense.value;
    if (categoryValue === "--Choose Category--"){
        cashLeftForCategory.textContent = `Category required`;
        limitInfo.textContent = `Category required`;
        limitValueForCategory.textContent = `Category required`;
        return;
    } else {
    const limit = await getLimitForCategory(categoryValue);
    let limitValue = await getLimitValueForCategory(categoryValue, dateValue);
    if (limitValue === null) {
        limitValue = 0;
    }
    renderInfoBox(limit, categoryValue);
    renderValueBox(limitValue, categoryValue);
    renderLeftBox(limit, limitValue, amount, categoryValue);
}
});

const form = document.querySelector("form");

form.addEventListener("submit", (event) => {
  const categoryValue = document.querySelector("#kategoria").value;
  
  if (categoryValue === "--Choose Category--") {
    event.preventDefault();
    // Display an error message or take any other appropriate action
    alert("Please choose a category before submitting the form.");
  }
});

