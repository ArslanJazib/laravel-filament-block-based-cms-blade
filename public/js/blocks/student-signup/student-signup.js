document.addEventListener("DOMContentLoaded", () => {
    const steps = document.querySelectorAll(".form-step");
    const nextBtns = document.querySelectorAll(".next");
    const prevBtns = document.querySelectorAll(".prev");
    const progress = document.querySelectorAll(".progressbar li");
    let currentStep = 0;

    function updateStep(n) {
        steps.forEach((step, i) => step.classList.toggle("active", i === n));
        progress.forEach((p, i) => p.classList.toggle("active", i <= n));
    }

    nextBtns.forEach(btn => btn.addEventListener("click", () => {
        if (currentStep < steps.length - 1) {
            currentStep++;
            updateStep(currentStep);
        }
    }));
    prevBtns.forEach(btn => btn.addEventListener("click", () => {
        if (currentStep > 0) {
            currentStep--;
            updateStep(currentStep);
        }
    }));
});