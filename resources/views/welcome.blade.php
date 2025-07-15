{{-- resources/views/welcome.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Service Container Demo</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.10.2/cdn.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.3.4/axios.min.js"></script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 20px;
            min-height: 100vh;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 2.5rem;
            font-weight: 600;
        }
        .header p {
            margin: 10px 0 0;
            opacity: 0.9;
            font-size: 1.1rem;
        }
        .content {
            padding: 30px;
        }
        .form-section {
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #374151;
        }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #d1d5db;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            outline: none;
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }
        .method-buttons {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }
        .method-button {
            padding: 15px 25px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .method-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        .di-button {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }
        .container-button {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
        }
        .facade-button {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }
        .response-section {
            margin-top: 30px;
            padding: 20px;
            background: #f1f5f9;
            border-radius: 10px;
            border-left: 4px solid #4f46e5;
        }
        .response-section h3 {
            margin-top: 0;
            color: #1e293b;
        }
        .response-item {
            background: white;
            padding: 20px;
            margin-bottom: 15px;
            border-radius: 8px;
            border-left: 4px solid #10b981;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .response-item.error {
            border-left-color: #ef4444;
            background: #fef2f2;
        }
        .response-item .method {
            font-weight: 600;
            color: #4f46e5;
            font-size: 1.1rem;
        }
        .response-item .message {
            margin-top: 8px;
            color: #374151;
            font-size: 1rem;
        }
        .response-details {
            margin-top: 12px;
            padding: 12px;
            background: #f8fafc;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
        }
        .response-details .detail-item {
            margin-bottom: 6px;
            font-size: 0.9rem;
        }
        .response-details .detail-label {
            font-weight: 600;
            color: #6b7280;
        }
        .response-details .detail-value {
            color: #1f2937;
            margin-left: 8px;
        }
        .driver-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
        }
        .driver-badge.email {
            background: #dbeafe;
            color: #1e40af;
        }
        .driver-badge.sms {
            background: #fef3c7;
            color: #92400e;
        }
        .driver-badge.slack {
            background: #ecfdf5;
            color: #065f46;
        }
        .loading {
            display: none;
            text-align: center;
            padding: 20px;
        }
        .loading.show {
            display: block;
        }
        .spinner {
            border: 4px solid #f3f4f6;
            border-top: 4px solid #4f46e5;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 10px;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .info-card {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .info-card h4 {
            margin-top: 0;
            color: #1e40af;
        }
        .info-card ul {
            margin: 10px 0;
            padding-left: 20px;
        }
        .info-card li {
            margin-bottom: 5px;
            color: #374151;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🚀 Laravel Service Container Demo</h1>
            <p>Test Service Provider, Service Container & Facade implementations</p>
        </div>

        <div class="content" x-data="notificationApp()">
            <!-- Information Cards -->

            <!-- Form Section -->
            <div class="form-section">
                <h3>📧 Send Notification</h3>
                <div class="form-group">
                    <label for="message">Message:</label>
                    <textarea id="message" x-model="form.message" rows="3" placeholder="Enter your notification message..."></textarea>
                </div>
                <div class="form-group">
                    <label for="recipient">Recipient:</label>
                    <input type="text" id="recipient" x-model="form.recipient" placeholder="user@example.com or +1234567890">
                </div>
                <div class="form-group">
                    <label for="driver">Driver:</label>
                    <select id="driver" x-model="form.driver">
                        <option value="email">Email</option>
                        <option value="sms">SMS</option>
                        <option value="slack">Slack</option>
                    </select>
                </div>

                <div class="method-buttons">
                    <button class="method-button di-button" @click="sendNotification('di')" :disabled="loading">
                        🔧 Dependency Injection
                    </button>
                    <button class="method-button container-button" @click="sendNotification('container')" :disabled="loading">
                        📦 Service Container
                    </button>
                    <button class="method-button facade-button" @click="sendNotification('facade')" :disabled="loading">
                        ✨ Facade
                    </button>
                </div>
            </div>

            <!-- Loading Section -->
            <div class="loading" :class="{ 'show': loading }">
                <div class="spinner"></div>
                <p>Sending notification...</p>
            </div>

            <!-- Response Section -->
            <div class="response-section" x-show="responses.length > 0">
                <h3>📊 Response Log</h3>
                <template x-for="response in responses.slice().reverse()" :key="response.id">
                    <div class="response-item" :class="{ 'error': !response.success }">
                        <div class="method" x-text="response.method"></div>
                        <div class="message" x-text="response.message"></div>
                        
                        <div class="response-details" x-show="response.success">
                            <div class="detail-item">
                                <span class="detail-label">Driver Used:</span>
                                <span class="driver-badge" :class="response.driver" x-text="response.driver"></span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Message Sent:</span>
                                <span class="detail-value" x-text="response.notification_message"></span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Recipient:</span>
                                <span class="detail-value" x-text="response.recipient"></span>
                            </div>
                        </div>
                        
                        <small x-text="response.timestamp" style="color: #6b7280; margin-top: 10px; display: block;"></small>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <script>
        // Set up CSRF token for axios
        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function notificationApp() {
            return {
                form: {
                    message: 'Hello! This is a test notification from Laravel Service Container Demo.',
                    recipient: 'user@example.com',
                    driver: 'email'
                },
                responses: [],
                loading: false,

                async sendNotification(method) {
                    this.loading = true;
                    
                    const endpoints = {
                        'di': '/send-notification-di',
                        'container': '/send-notification-container',
                        'facade': '/send-notification-facade'
                    };

                    try {
                        const response = await axios.post(endpoints[method], this.form);
                        
                        this.responses.push({
                            id: Date.now(),
                            success: response.data.success,
                            method: response.data.method,
                            message: response.data.message,
                            driver: response.data.driver,
                            notification_message: response.data.notification_message,
                            recipient: response.data.recipient,
                            timestamp: new Date().toLocaleTimeString()
                        });
                    } catch (error) {
                        this.responses.push({
                            id: Date.now(),
                            success: false,
                            method: method.toUpperCase(),
                            message: error.response?.data?.error || 'An error occurred',
                            timestamp: new Date().toLocaleTimeString()
                        });
                    } finally {
                        this.loading = false;
                    }
                }
            }
        }
    </script>
</body>
</html>