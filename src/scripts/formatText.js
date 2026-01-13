export function formatText() {
  const format = (message) => {
    if (!message) return "";

    let formatted = message.replace(/\n/g, "<br>");
    formatted = formatted.replace(/\*\*(.*?)\*\*/g, "<strong>$1</strong>");

    return formatted;
  };

  return format;
}
