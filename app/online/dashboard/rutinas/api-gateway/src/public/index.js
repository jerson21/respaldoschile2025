// MDN WebSocket documentation
// https://developer.mozilla.org/en-US/docs/Web/API/WebSocket

const socket = new WebSocket('wss://yfbl2f1s7h.execute-api.us-east-2.amazonaws.com/production')

socket.addEventListener('open', e => {
  console.log('WebSocket esta conectado')
})

socket.addEventListener('close', e => console.log('WebSocket is closed'))

socket.addEventListener('error', e => console.error('WebSocket is in error', e))

socket.addEventListener('message', e => {
  // console.log('WebSocket received a message:', e)
  console.log('Your answer is:', JSON.parse(e.data).message)
})

window.ask = function (msg) {
  const payload = {
    action: 'message',
    msg
  }
  socket.send(JSON.stringify(payload))
}