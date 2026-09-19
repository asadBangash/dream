importScripts(
    "https://www.gstatic.com/firebasejs/10.0.0/firebase-app-compat.js"
);
importScripts(
    "https://www.gstatic.com/firebasejs/10.0.0/firebase-messaging-compat.js"
);

firebase.initializeApp({
    apiKey: "AIzaSyBtZjr_UQUb79QUhKeMgMbYRRxSBPqvtrs",
    authDomain: "onest-school.firebaseapp.com",
    projectId: "onest-school",
    storageBucket: "onest-school.firebasestorage.app",
    messagingSenderId: "224249204011",
    appId: "1:224249204011:web:b4e2fe4dc4863e465f896e",
    measurementId: "G-8DNYD4JK9N"
});

const messaging = firebase.messaging();

messaging.onBackgroundMessage(function(payload) {
    console.log('Received background message ', payload);
    const notificationTitle = payload.notification.title;
    const notificationOptions = {
        body: payload.notification.body,
        icon: payload.notification.icon
    };

    self.registration.showNotification(notificationTitle, notificationOptions);
});
