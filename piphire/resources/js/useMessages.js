import { ref, onMounted } from "vue";

const url = "/MSG";
const newMessageUrl = "/newMessage";

// I will call useMessages every 10 seconds
export default function useMessages(phoneNumber) {
  const response = ref();
  const request = async () => {
    const res = await fetch(url, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        phoneNumber: phoneNumber,
      }),
    });
    const data = await res.json();
    console.log('data', data);
    response.value = convert(data);
  };
  onMounted(() => {
    request();
  });

  return [response, request];
}

export function sendNewMessage(messageRef, phoneNumber, newMessage) {
  const request = async (msg, phn) => {
    console.log(JSON.stringify({ message: msg, phoneNumber: phn }));

    // console.log('new_message',data);
    const res = await fetch(newMessageUrl, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ message: msg, phoneNumber: phn }),
    });
    const data = await res.json();
    console.log('new_message', data);
    return data;
  };
  request(newMessage, phoneNumber).then((res) => {
    console.log(convert(res));
    messageRef.value = convert(res);
  });
}

const messageObject = (message, type, timestamp) => {
  return {
    message: message,
    type: type,
    timestamp: timestamp,
  };
};

function convert(raw) {
  const messages = [];
  for (const msg of raw) {
    if (msg["Qn"]) {
      messages.push(messageObject(msg["Qn"], "right", msg["Sent"]));
    }
    if (msg["response"]) {
      messages.push(messageObject(msg["response"], "left", msg["Recieved"]));
    }
  }
  return messages;
}

