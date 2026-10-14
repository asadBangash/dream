@php
    $firebaseWeb = config('firebase.web', []);
    $firebaseReady = filled($firebaseWeb['project_id'] ?? null)
        && filled($firebaseWeb['api_key'] ?? null)
        && filled($firebaseWeb['app_id'] ?? null);
@endphp
@if ($firebaseReady)
<script type="module">
    import {initializeApp} from "https://www.gstatic.com/firebasejs/10.13.1/firebase-app.js";
    import {getMessaging, getToken, onMessage} from "https://www.gstatic.com/firebasejs/10.13.1/firebase-messaging.js";

    const firebaseConfig = {
        apiKey: @json($firebaseWeb['api_key']),
        authDomain: @json($firebaseWeb['auth_domain']),
        projectId: @json($firebaseWeb['project_id']),
        storageBucket: @json($firebaseWeb['storage_bucket']),
        messagingSenderId: @json($firebaseWeb['messaging_sender_id']),
        appId: @json($firebaseWeb['app_id']),
        measurementId: @json($firebaseWeb['measurement_id']),
    };

    const app = initializeApp(firebaseConfig);
    const messaging = getMessaging(app);

    async function requestNotificationPermission() {
        try {
            const permission = await Notification.requestPermission();

            if (permission === 'granted') {
                const token = await getToken(messaging);

                if (token) {
                    await fetch('/store-fcm-token', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': @json(csrf_token())
                        },
                        body: JSON.stringify({token: token})
                    });

                    await fetch('/subscribe-to-topic', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': @json(csrf_token())
                        },
                        body: JSON.stringify({token: token, topic: 'hrm_notification'})
                    }).then(() => registerServiceWorker());
                }
            }
        } catch (error) {
            console.warn('Firebase messaging setup skipped:', error);
        }
    }

    requestNotificationPermission();

    function registerServiceWorker() {
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/service-worker.js').catch(function () {});
        }
    }

    onMessage(messaging, (payload) => {
        if (payload.notification) {
            const { title = 'Notification', body = '', icon = '/default-icon.png' } = payload.notification;
            new Notification(title, { body, icon });
        }
    });
</script>
@endif
