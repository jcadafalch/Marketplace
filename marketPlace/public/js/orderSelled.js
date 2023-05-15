const paidButton = document.querySelector(".paid");
const sentButton = document.querySelector(".sent");

const setOrderLineAsPaid = async (orderLineId) => {
    try {
        const response = await fetch(`/venta/paid/${orderLineId}`);

        if (response.ok) {
            const data = await response.json();
            return data;
        } else {
            return null;
        }
    } catch (error) {
        return null;
    }
};

const setOrderLineAsSent = async (orderLineId) => {
    try {
        const response = await fetch(`/venta/sent/${orderLineId}`);

        if (response.ok) {
            const data = await response.json();
            return data;
        } else {
            return null;
        }
    } catch (error) {
        return null;
    }
};

paidButton.addEventListener("click", (event) => {
    event.preventDefault();
    setOrderLineAsPaid(parseInt(paidButton.id)).then((res) => {
        paidButton.setAttribute("disabled", "disabled");
        sentButton.removeAttribute("disabled");
    });
});

sentButton.addEventListener("click", (event) => {
    event.preventDefault();
    setOrderLineAsSent(parseInt(sentButton.id)).then((res) => {
        sentButton.setAttribute("disabled", "disabled");
    });
});
