/**
 * Prevent Double Form Submission
 * 
 * This script prevents users from submitting forms multiple times
 * by disabling the submit button and showing a loading state.
 * 
 * Usage:
 * 1. Include this file in your blade template
 * 2. Call preventDoubleSubmit('formId', 'Optional custom loading text')
 */

/**
 * Prevent double submission for a specific form
 * @param {string} formId - The ID of the form element
 * @param {string} loadingText - Optional custom loading text (default: 'Menghantar...')
 * @param {function} onSubmit - Optional callback function before submission
 */
function preventDoubleSubmit(formId, loadingText = 'Menghantar...', onSubmit = null) {
    const form = document.getElementById(formId);
    
    if (!form) {
        console.error(`Form with ID '${formId}' not found`);
        return;
    }

    // Track submission state
    let isSubmitting = false;
    let originalButtonContents = new Map();

    form.addEventListener('submit', function(e) {
        // If already submitting, prevent the form submission
        if (isSubmitting) {
            e.preventDefault();
            console.log('Form submission prevented: Already submitting');
            return false;
        }

        // Run custom validation callback if provided
        if (onSubmit && typeof onSubmit === 'function') {
            const shouldContinue = onSubmit(e);
            if (shouldContinue === false) {
                return; // Allow other event handlers to run
            }
        }

        // Mark as submitting
        isSubmitting = true;
        console.log('Form submission started');

        // Find all submit buttons in the form
        const submitButtons = form.querySelectorAll('button[type="submit"], input[type="submit"]');
        
        submitButtons.forEach((button, index) => {
            // Store original content
            originalButtonContents.set(index, button.innerHTML);
            
            // Disable the button
            button.disabled = true;
            button.style.opacity = '0.6';
            button.style.cursor = 'not-allowed';
            
            // Add loading state
            if (button.tagName === 'BUTTON') {
                button.innerHTML = `
                    <div class="flex items-center justify-center gap-2">
                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>${loadingText}</span>
                    </div>
                `;
            }
        });

        // Add a class to the form to indicate it's submitting
        form.classList.add('is-submitting');

        // Disable all form inputs to prevent changes during submission
        const formInputs = form.querySelectorAll('input, textarea, select');
        formInputs.forEach(input => {
            if (!input.disabled) {
                input.dataset.wasEnabled = 'true';
                input.disabled = true;
            }
        });

        // Set a safety timeout to re-enable the form if submission fails
        // This prevents the form from being permanently locked if there's an error
        const safetyTimeout = setTimeout(() => {
            if (isSubmitting) {
                console.warn('Form submission timeout - re-enabling form');
                resetForm();
            }
        }, 30000); // 30 seconds timeout

        // Store the timeout ID so we can clear it if needed
        form.dataset.safetyTimeout = safetyTimeout;

        // Allow the form to submit
        return true;
    });

    // Reset form function
    function resetForm() {
        isSubmitting = false;
        
        const submitButtons = form.querySelectorAll('button[type="submit"], input[type="submit"]');
        submitButtons.forEach((button, index) => {
            button.disabled = false;
            button.style.opacity = '1';
            button.style.cursor = 'pointer';
            
            if (originalButtonContents.has(index)) {
                button.innerHTML = originalButtonContents.get(index);
            }
        });

        form.classList.remove('is-submitting');

        // Re-enable inputs that were enabled before
        const formInputs = form.querySelectorAll('input, textarea, select');
        formInputs.forEach(input => {
            if (input.dataset.wasEnabled === 'true') {
                input.disabled = false;
                delete input.dataset.wasEnabled;
            }
        });

        // Clear the safety timeout
        if (form.dataset.safetyTimeout) {
            clearTimeout(parseInt(form.dataset.safetyTimeout));
            delete form.dataset.safetyTimeout;
        }
    }

    // Listen for page navigation away (for browser back button, etc.)
    window.addEventListener('beforeunload', function() {
        if (isSubmitting) {
            // Browser will show default confirmation dialog
            return 'Aduan sedang dihantar. Adakah anda pasti mahu meninggalkan halaman ini?';
        }
    });

    // Expose reset function globally for error handling
    window[`reset_${formId}`] = resetForm;
}

/**
 * Initialize double submit prevention for all forms with data-prevent-double-submit attribute
 */
function initAllForms() {
    document.querySelectorAll('[data-prevent-double-submit]').forEach(form => {
        const loadingText = form.dataset.loadingText || 'Menghantar...';
        preventDoubleSubmit(form.id, loadingText);
    });
}

// Auto-initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initAllForms);
} else {
    initAllForms();
}

/**
 * Alternative method: Add to any button directly
 * Usage: <button onclick="handleSingleClick(this, function() { /* your code */ })">
 */
function handleSingleClick(button, callback) {
    if (button.disabled) {
        return;
    }

    button.disabled = true;
    button.style.opacity = '0.6';
    const originalHTML = button.innerHTML;
    
    button.innerHTML = `
        <div class="flex items-center justify-center gap-2">
            <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span>Memproses...</span>
        </div>
    `;

    // Execute callback
    if (callback && typeof callback === 'function') {
        callback();
    }

    // Safety timeout to re-enable
    setTimeout(() => {
        button.disabled = false;
        button.style.opacity = '1';
        button.innerHTML = originalHTML;
    }, 30000);
}

