class DynamicRangeSelector {
    constructor(wrapperElement) {
        this.wrapper = wrapperElement;
        this.track = this.wrapper.querySelector('.range-track');
        this.minHandle = this.wrapper.querySelector('#minHandle');
        this.maxHandle = this.wrapper.querySelector('#maxHandle');
        this.minValueDisplay = document.getElementById('minValueDisplay');
        this.maxValueDisplay = document.getElementById('maxValueDisplay');
        
        // Get min and max values
        this.minValue = parseInt(this.wrapper.dataset.min) || 0;
        this.maxValue = parseInt(this.wrapper.dataset.max) || 100;
        
        // Get initial start values (if provided)
        this.startMin = this.wrapper.dataset.startMin !== '' 
            ? parseInt(this.wrapper.dataset.startMin) 
            : this.minValue;
        this.startMax = this.wrapper.dataset.startMax !== '' 
            ? parseInt(this.wrapper.dataset.startMax) 
            : this.maxValue;

        // Current values
        this.currentMin = this.startMin;
        this.currentMax = this.startMax;

        this.initEventListeners();
        this.updateRange();
    }

    // Convert value to pixel position
    valueToPixel(value) {
        const wrapperWidth = this.wrapper.offsetWidth;
        return ((value - this.minValue) / (this.maxValue - this.minValue)) * wrapperWidth;
    }

    // Convert pixel position to value
    pixelToValue(pixel) {
        const wrapperWidth = this.wrapper.offsetWidth;
        const value = this.minValue + 
            ((pixel / wrapperWidth) * (this.maxValue - this.minValue));
        return Math.round(value);
    }

    // Update range display
    updateRange() {
        const minPixel = this.valueToPixel(this.currentMin);
        const maxPixel = this.valueToPixel(this.currentMax);

        this.minHandle.style.left = `${minPixel}px`;
        this.maxHandle.style.left = `${maxPixel}px`;
        this.track.style.left = `${minPixel}px`;
        this.track.style.width = `${maxPixel - minPixel}px`;

        this.minValueDisplay.textContent = this.currentMin;
        this.maxValueDisplay.textContent = this.currentMax;
    }

    // Setup dragging for handles
    initEventListeners() {
        this.setupHandleDragging(this.minHandle, true);
        this.setupHandleDragging(this.maxHandle, false);
        window.addEventListener('resize', () => this.updateRange());
    }

    setupHandleDragging(handle, isMinHandle) {
        let isDragging = false;

        handle.addEventListener('mousedown', (e) => {
            e.preventDefault();
            isDragging = true;
            document.addEventListener('mousemove', dragHandle);
            document.addEventListener('mouseup', stopDragging);
        });

        const dragHandle = (e) => {
            if (!isDragging) return;

            // Calculate new position relative to wrapper
            const rect = this.wrapper.getBoundingClientRect();
            let newPixel = e.clientX - rect.left;

            // Constrain within wrapper
            newPixel = Math.max(0, Math.min(newPixel, this.wrapper.offsetWidth));
            const newValue = this.pixelToValue(newPixel);

            // Update based on which handle is being dragged
            if (isMinHandle) {
                // Ensure min handle doesn't exceed max handle
                this.currentMin = Math.min(newValue, this.currentMax);
            } else {
                // Ensure max handle doesn't go below min handle
                this.currentMax = Math.max(newValue, this.currentMin);
            }

            this.updateRange();
        };

        const stopDragging = () => {
            isDragging = false;
            document.removeEventListener('mousemove', dragHandle);
            document.removeEventListener('mouseup', stopDragging);
        };
    }

    // Method to get current range values
    getValues() {
        return {
            min: this.currentMin,
            max: this.currentMax
        };
    }
}

// Initialize the range selector
document.addEventListener('DOMContentLoaded', () => {
    const rangeWrapper = document.getElementById('rangeWrapper');
    const rangeSelector = new DynamicRangeSelector(rangeWrapper);
});