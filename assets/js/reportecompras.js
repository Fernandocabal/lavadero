function setDates() {
    const firstDateInput = document.getElementById('firstdate');
    const lastDateInput = document.getElementById('lastdate');
    const today = new Date();
    const currentYear = today.getFullYear();
    const currentMonth = String(today.getMonth() + 1).padStart(2, '0');
    const currentDate = String(today.getDate()).padStart(2, '0');
    firstDateInput.value = `${currentYear}-${currentMonth}-01`;
    lastDateInput.value = `${currentYear}-${currentMonth}-${currentDate}`;
}
window.onload = setDates;