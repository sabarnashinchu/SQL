document.addEventListener('DOMContentLoaded', () => {
    const display = document.getElementById('display');
    const buttons = document.querySelectorAll('.btn');
    const clearHistoryBtn = document.getElementById('clear-history');
    const historyList = document.getElementById('history-list');
    
    let currentExpression = '';
    let lastOperation = null;
    let calculationHistory = [];
    
    // Set focus to display on page load
    display.focus();
    
    // Load history when page loads
    loadHistory();
    
    // Add event listeners to calculator buttons
    buttons.forEach(button => {
        button.addEventListener('click', (e) => {
            buttonClick(button.id, button.textContent);
            
            // Add button press animation
            button.classList.add('active');
            setTimeout(() => button.classList.remove('active'), 100);
        });
    });
    
    // Function to handle button clicks
    function buttonClick(id, value) {
        switch(id) {
            case 'clear':
                currentExpression = '';
                display.value = '';
                break;
            case 'backspace':
                currentExpression = currentExpression.slice(0, -1);
                display.value = currentExpression;
                break;
            case 'equals':
                calculateResult();
                break;
            case 'add':
                currentExpression += '+';
                display.value = currentExpression;
                break;
            case 'subtract':
                currentExpression += '-';
                display.value = currentExpression;
                break;
            case 'multiply':
                currentExpression += '×';
                display.value = currentExpression;
                break;
            case 'divide':
                currentExpression += '÷';
                display.value = currentExpression;
                break;
            case 'decimal':
                // Prevent multiple decimal points in a number
                const lastNumber = currentExpression.split(/[\+\-\×\÷]/).pop();
                if (!lastNumber.includes('.')) {
                    currentExpression += '.';
                    display.value = currentExpression;
                }
                break;
            default:
                // For number buttons
                currentExpression += value;
                display.value = currentExpression;
        }
    }
    
    // Function to calculate result
    function calculateResult() {
        try {
            if (!currentExpression) return;
            
            // Replace display symbols with actual operators
            let expressionToEvaluate = currentExpression
                .replace(/×/g, '*')
                .replace(/÷/g, '/');
            
            // Store the original expression before evaluation
            const originalExpression = currentExpression;
            
            const result = eval(expressionToEvaluate);
            
            if (isNaN(result) || !isFinite(result)) {
                display.value = 'Error';
                showNotification('Invalid calculation', 'error');
            } else {
                // Format the result
                const formattedResult = Number.isInteger(result) ? 
                    result : parseFloat(result.toFixed(8)).toString();
                
                display.value = formattedResult;
                
                // Save calculation to history
                saveCalculation(originalExpression, formattedResult);
                
                // Reset current expression to result for further calculations
                currentExpression = formattedResult.toString();
                
                // Store last operation
                lastOperation = {
                    expression: originalExpression,
                    result: formattedResult
                };
            }
        } catch (error) {
            display.value = 'Error';
            showNotification('Invalid calculation', 'error');
        }
    }
    
    // Add keyboard support
    document.addEventListener('keydown', (e) => {
        e.preventDefault();
        
        // Numbers
        if (/^[0-9]$/.test(e.key)) {
            buttonClick(e.key, e.key);
        }
        
        // Operators
        switch(e.key) {
            case 'Enter':
                buttonClick('equals', '=');
                break;
            case '=':
                buttonClick('equals', '=');
                break;
            case '+':
                buttonClick('add', '+');
                break;
            case '-':
                buttonClick('subtract', '-');
                break;
            case '*':
                buttonClick('multiply', '×');
                break;
            case '/':
                buttonClick('divide', '÷');
                break;
            case '.':
                buttonClick('decimal', '.');
                break;
            case 'Backspace':
                buttonClick('backspace', '⌫');
                break;
            case 'Delete':
                buttonClick('clear', 'C');
                break;
            case 'Escape':
                buttonClick('clear', 'C');
                break;
        }
    });
    
    // Clear history button event listener
    clearHistoryBtn.addEventListener('click', () => {
        if (confirm('Are you sure you want to clear all calculation history?')) {
            clearHistory();
        }
    });
    
    // Function to show notification
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        // Fade in
        setTimeout(() => {
            notification.style.opacity = '1';
            notification.style.transform = 'translateY(0)';
        }, 10);
        
        // Remove after a delay
        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transform = 'translateY(-20px)';
            
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
    }
    
    // Function to save calculation to database
    function saveCalculation(expression, result) {
        fetch('api/save_calculation.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                expression: expression,
                result: result
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Server responded with status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Add to local history cache
                const timestamp = new Date().toLocaleString();
                calculationHistory.unshift({
                    id: data.id,
                    expression: expression,
                    result: result,
                    timestamp: timestamp
                });
                
                // Update displayed history
                updateHistoryDisplay();
            }
        })
        .catch(error => {
            console.error('Error saving calculation:', error);
            // Display error but don't interrupt user
            showNotification('Error saving calculation', 'error');
        });
    }
    
    // Function to load history from database
    function loadHistory() {
        // Show loading indicator
        historyList.innerHTML = '<p class="loading">Loading history...</p>';
        
        fetch('api/get_history.php')
        .then(response => {
            if (!response.ok) {
                throw new Error(`Server responded with status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            // Store history in memory
            calculationHistory = data;
            
            // Update displayed history
            updateHistoryDisplay();
        })
        .catch(error => {
            console.error('Error loading history:', error);
            historyList.innerHTML = '<p class="error">Error loading calculation history</p>';
        });
    }
    
    // Function to update history display
    function updateHistoryDisplay() {
        // Clear current history display
        historyList.innerHTML = '';
        
        // If there are no records
        if (calculationHistory.length === 0) {
            historyList.innerHTML = '<p class="no-history">No calculations yet</p>';
            return;
        }
        
        // Add each history item to the display
        calculationHistory.forEach(item => {
            const historyItem = document.createElement('div');
            historyItem.classList.add('history-item');
            historyItem.dataset.id = item.id;
            
            const expressionSpan = document.createElement('span');
            expressionSpan.classList.add('expression');
            expressionSpan.textContent = item.expression;
            
            const resultSpan = document.createElement('span');
            resultSpan.classList.add('result');
            resultSpan.textContent = '= ' + item.result;
            
            const timeSpan = document.createElement('span');
            timeSpan.classList.add('timestamp');
            timeSpan.textContent = formatDate(item.timestamp);
            
            // Add click handler to reuse calculation
            historyItem.addEventListener('click', () => {
                currentExpression = item.expression;
                display.value = currentExpression;
            });
            
            historyItem.appendChild(expressionSpan);
            historyItem.appendChild(resultSpan);
            historyItem.appendChild(timeSpan);
            
            historyList.appendChild(historyItem);
        });
    }
    
    // Function to clear history
    function clearHistory() {
        fetch('api/clear_history.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Server responded with status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Clear local history cache
                calculationHistory = [];
                
                // Update displayed history
                historyList.innerHTML = '<p class="no-history">No calculations yet</p>';
                showNotification('History cleared successfully');
            }
        })
        .catch(error => {
            console.error('Error clearing history:', error);
            showNotification('Error clearing calculation history', 'error');
        });
    }
    
    // Helper function to format date
    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleString();
    }
}); 