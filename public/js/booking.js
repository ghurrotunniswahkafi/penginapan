document.addEventListener("DOMContentLoaded", () => {
    const roomType = document.getElementById("room_type");
    const roomImage = document.getElementById("roomImage");

    const images = {
        "Standard Room": "/images/standard.jpg",
        "Deluxe Room": "/images/deluxe.jpg",
        "Suite Room": "/images/suite.jpg"
    };

    function updateRoomImage() {
        const selected = roomType.value;
        if (images[selected]) {
            roomImage.src = images[selected];
            roomImage.style.display = "block";
        } else {
            roomImage.style.display = "none";
        }
    }
    updateRoomImage();
    roomType.addEventListener("change", updateRoomImage);
});
