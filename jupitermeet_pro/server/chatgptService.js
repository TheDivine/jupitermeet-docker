const OpenAI = require("openai");

const openai = new OpenAI({
  baseURL: process.env.AI_CHATBOT_API_URL,
  apiKey: process.env.AI_CHATBOT_API_KEY
});

const conversations = {};
const lastRequestTime = {};
const userQuota = {};

async function getChatGPTResponse(socketId, message) {
  const now = Date.now();

  //make sure there is a gap before user sends another message
  if (lastRequestTime[socketId] && now - lastRequestTime[socketId] < process.env.CHATGPT_SECONDS * 1000) {
    return 'Please wait before sending another message.';
  }

  if (!userQuota[socketId]) {
    userQuota[socketId] = 0;
  }

  //make sure to check the message limit
  if (userQuota[socketId] >= process.env.CHATGPT_MESSAGE_LIMIT) {
    return 'You have reached your meeting limit for chat requests.';
  }

  userQuota[socketId]++;

  lastRequestTime[socketId] = now;

  if (!conversations[socketId]) {
    conversations[socketId] = [];
  }

  //keep the conversation length under control
  if (conversations[socketId].length >= process.env.CHATGPT_MAX_CONVERSATION_LENGTH * 2) {
    conversations[socketId].splice(0, 2);
  }

  //add user message to conversation history
  conversations[socketId].push({ role: 'user', content: message });

  const completion = await openai.chat.completions.create({
    messages: conversations[socketId],
    model: process.env.AI_CHATBOT_MODEL,
  });

  const reply = completion.choices[0].message.content;
  return reply;
}

// remove socketId from the conversations arrays
const removeSocketId = function (socketId) {
  delete conversations[socketId];
  delete lastRequestTime[socketId];
  delete userQuota[socketId];
}

module.exports = { getChatGPTResponse, removeSocketId };
