/*
Give the service worker access to Firebase Messaging.
Note that you can only use Firebase Messaging here, other Firebase libraries are not available in the service worker.
*/
importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase.js');
importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-messaging.js');

/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
* New configuration for app@pulseservice.com
*/
firebase.initializeApp({


        apiKey: "AIzaSyDUxKPRi3ec_FQxDv33hOssPfx7b75yi4c",
        authDomain: "pttr-12c10.firebaseapp.com",
        databaseURL: "https://pttr-12c10-default-rtdb.firebaseio.com",
        projectId: "pttr-12c10",
        storageBucket: "pttr-12c10.appspot.com",
        messagingSenderId: "760302918794",
        appId: "1:760302918794:web:ddd0728da67dad0267a173",
        measurementId: "G-P01WSBPYRY"
    });




/*
Retrieve an instance of Firebase Messaging so that it can handle background messages.
*/
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
    console.log(
        "[firebase-messaging-sw.js] Received background message ",
        payload,
    );
    /* Customize notification here */
    const notificationTitle = "Background Message Title";
    const notificationOptions = {
        body: "Background Message body.",
        icon: "/itwonders-web-logo.png",
    };

    return self.registration.showNotification(
        notificationTitle,
        notificationOptions,
    );
});


// messaging.onMessage(function(payload) {
//     const noteTitle = payload.notification.title;
//     const noteOptions = {
//         body: payload.notification.body,
//         icon: payload.notification.icon,
//     };
//     new Notification(noteTitle, noteOptions);
// });

