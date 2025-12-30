import { ref } from "vue";
import { SupabaseClient } from "@supabase/supabase-js";

const localMessages = ref([]);
const localCurrentNode = ref(null);
const localMessageFlow = ref([]);

const CHAT_STATE_KEY = "chatStatusKey";
const CURRENT_NODE_KEY = "currentNodeKey";
const MESSAGE_FLOW_KEY = "messageFlowKey";

export function chatState() {
  const saveChatState = (msgs) => {
    localMessages.value = msgs;
    sessionStorage.setItem(CHAT_STATE_KEY, JSON.stringify(localMessages.value));
  };

  const saveCurrentNode = (current) => {
    localCurrentNode.value = current;
    sessionStorage.setItem(
      CURRENT_NODE_KEY,
      JSON.stringify(localCurrentNode.value)
    );
  };

  const saveMessageFlow = (history) => {
    localMessageFlow.value = history;
    sessionStorage.setItem(
      MESSAGE_FLOW_KEY,
      JSON.stringify(localMessageFlow.value)
    );
  };

  const getChatState = async () => {
    const local = JSON.parse(sessionStorage.getItem(CHAT_STATE_KEY)) || [];
    return local;
  };

  const getCurrentNode = async () => {
    const local = JSON.parse(sessionStorage.getItem(CURRENT_NODE_KEY)) || [];
    return local;
  };

  const getMessageFlow = async () => {
    const local = JSON.parse(sessionStorage.getItem(MESSAGE_FLOW_KEY)) || [];
    return local;
  };

  const clearAllData = () => {
    localMessages.value = [];
    localCurrentNode.value = null;
    localMessageFlow.value = [];

    sessionStorage.setItem(CHAT_STATE_KEY, JSON.stringify(localMessages.value));
    sessionStorage.setItem(
      CURRENT_NODE_KEY,
      JSON.stringify(localCurrentNode.value)
    );
    sessionStorage.setItem(
      MESSAGE_FLOW_KEY,
      JSON.stringify(localMessageFlow.value)
    );
  };

  return {
    saveChatState,
    saveCurrentNode,
    saveMessageFlow,
    getChatState,
    getCurrentNode,
    getMessageFlow,
    clearAllData,
  };
}
