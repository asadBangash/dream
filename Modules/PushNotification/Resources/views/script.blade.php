<script type="module">

    import {initializeApp} from "https://www.gstatic.com/firebasejs/10.13.1/firebase-app.js";
    import {getMessaging, getToken, onMessage} from "https://www.gstatic.com/firebasejs/10.13.1/firebase-messaging.js";
    // Your web app's Firebase configuration
    const firebaseConfig = {
        apiKey: '{{ env('FIREBASE_API_KEY') }}',
        authDomain: '{{ env('FIREBASE_AUTH_DOMAIN') }}',
        projectId: '{{ env('FIREBASE_PROJECT_ID') }}',
        storageBucket: '{{ env('FIREBASE_STORAGE_BUCKET') }}',
        messagingSenderId: '{{ env('FIREBASE_MESSAGING_SENDER_ID') }}',
        appId: '{{ env('FIREBASE_APP_ID') }}',
        measurementId: '{{ env('FIREBASE_MEASUREMENT_ID') }}'
    };

    // Initialize Firebase
    const app = initializeApp(firebaseConfig);
    // Initialize Firebase Messaging
    const messaging = getMessaging(app);



    // Request permission and get the FCM token
    async function requestNotificationPermission() {
        try {
            const permission = await Notification.requestPermission();

            if (permission === 'granted') {
                console.log('Notification permission granted.');
                const token = await getToken(messaging);

                if (token) {
                    console.log('FCM Token:', token);
                    // Send the token to your server using Axios
                    await fetch('/store-fcm-token', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'  // Laravel CSRF token
                        },
                        body: JSON.stringify({token: token})
                    })
                        .then(response => response.json())
                        .then(data => {
                            console.log('Token saved on server:', data);
                        })
                        .catch(error => {
                            console.error('Error saving token:', error);
                        });

                    // Subscribe to a topic (e.g., 'news')
                    await fetch('/subscribe-to-topic', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'  // Laravel CSRF token
                        },
                        body: JSON.stringify({token: token, topic: 'hrm_notification'})
                    })
                        .then(response => response.json())
                        .then(data => {
                            registerServiceWorker()
                            console.log('Subscribed to topic:', data);
                        })
                        .catch(error => {
                            console.error('Error subscribing to topic:', error);
                        });
                } else {
                    console.log('No registration token available.');
                }
            } else {
                console.log('Notification permission denied.');
            }
        } catch (error) {
            console.error('Error getting permission or token:', error);
        }
    }

    // Request permission for notifications
    requestNotificationPermission();


    function registerServiceWorker() {
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker
                .register('/service-worker.js')
                .then(function (registration) {
                    console.log('Service Worker registered with scope:', registration.scope);
                })
                .catch(function (error) {
                    console.error('Service Worker registration failed:', error);
                });
        }
    }
    // Handle foreground messages
    onMessage(messaging, (payload) => {
        console.log('Message received: ', payload);

        // Check if payload.notification is defined before destructuring
        if (payload.notification) {
            const { title = 'Default Title', body = 'Default Body', icon = '/default-icon.png' } = payload.notification;

            const notificationOptions = {
                body: body,
                icon: icon
            };
            // Show notification
            new Notification(title, notificationOptions);
        } else {
            console.log('No notification data available in the payload.');
        }
    });
</script>


