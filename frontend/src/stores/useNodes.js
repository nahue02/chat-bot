import { ref } from "vue";
import { supabase } from "@/lib/supabaseClient";
import { chatState } from "./chatState";

const nodes = ref([]);
const sessionKey = "local";
const { clearAllData } = chatState();

export function useNodes() {
  const createNode = (form) => {
    const local = JSON.parse(sessionStorage.getItem(sessionKey)) || [];
    const newId = local.length + 1;

    const newNode = {
      id: newId,
      title: form.title || "Node " + newId,
      message: form.message,
      node_options:
        form.options.map((opt) => ({
          _id: opt._id ?? crypto.randomUUID(),
          text: opt.text,
          next_node: Number(opt.next_node),
        })) || [],
      node_positions: [{ x: 100, y: 100 }],
    };

    local.push(newNode);
    nodes.value = local;

    clearAllData();
    sessionStorage.setItem(sessionKey, JSON.stringify(nodes.value));
  };

  const loadNodes = async (api) => {
    const local = JSON.parse(sessionStorage.getItem(sessionKey));

    if (local) {
      nodes.value = local;
    } else {
      const { data, error } = await supabase.from("chat_node").select(`
        *,
        node_options(*),
        node_positions(*)
      `);

      data.map((node) => {
        console.log(node);
        const newNode = {
          id: node.id,
          title: node.title,
          message: node.message,
          node_options: node.node_options || [],
          node_positions: node.node_positions || [{ x: 100, y: 100 }],
        };

        console.log(newNode);
        nodes.value.push(newNode);
      });

      console.log(nodes.value);
      sessionStorage.setItem(sessionKey, JSON.stringify(nodes.value));
    }
  };

  const loadNode = async (id) => {
    const index = nodes.value.findIndex((n) => String(n.id) === String(id));
    if (index === -1) return;

    return nodes.value[index];
  };

  const updateNode = (id, form) => {
    const index = nodes.value.findIndex((n) => String(n.id) === String(id));
    if (index === -1) return;

    nodes.value[index].title = form.title || "Node " + nodes.value[index].id;
    nodes.value[index].message = form.message;
    nodes.value[index].node_options = form.options.map((opt) => ({
      _id: opt._id ?? crypto.randomUUID(),
      text: opt.text,
      next_node: Number(opt.next_node),
    }));

    clearAllData();
    sessionStorage.setItem(sessionKey, JSON.stringify(nodes.value));
  };

  const deleteNode = (id) => {
    const index = nodes.value.findIndex((n) => String(n.id) === String(id));
    if (index === -1) return;

    nodes.value.splice(index, 1);

    nodes.value = nodes.value.filter((n) => String(n.id) !== String(id));

    nodes.value.forEach((n) => {
      n.options = n.options.filter(
        (opt) => String(opt.next_node) !== String(id)
      );
    });

    clearAllData();
    sessionStorage.setItem(sessionKey, JSON.stringify(nodes.value));
  };

  const updateNodePosition = (id, position) => {
    const index = nodes.value.findIndex((n) => String(n.id) === String(id));
    if (index === -1) return;

    console.log("before: ", nodes.value[index].node_positions[0]);
    nodes.value[index].node_positions[0] = position;
    console.log("after: ", nodes.value[index].node_positions[0]);

    sessionStorage.setItem(sessionKey, JSON.stringify(nodes.value));
  };

  const clearAll = () => {
    sessionStorage.clear();
  };

  return {
    nodes,
    createNode,
    loadNodes,
    loadNode,
    updateNode,
    deleteNode,
    updateNodePosition,
    clearAll,
  };
}
