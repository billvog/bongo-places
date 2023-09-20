class Button extends HTMLButtonElement {
  isLoading = false;
  wasDisabledBeforeLoading = false;

  constructor() {
    super();
  }

  setIsLoading(isLoading) {
    this.isLoading = isLoading;

    // Toggle properties.
    this.disabled = this.isLoading;

    // Add or remove `loading` class.
    if (this.isLoading) {
      this.classList.add("loading");
    } else {
      this.classList.remove("loading");
    }
  }
}

customElements.define("custom-button", Button, { extends: "button" });
