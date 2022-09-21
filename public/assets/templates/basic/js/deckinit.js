
var prefix = Deck.prefix
var transform = prefix('transform')
var translate = Deck.translate
var $container = document.getElementById('cards')
var deck = Deck()
var acesClicked = []
var kingsClicked = []

deck.cards.forEach(function (card, i) {
  card.enableDragging()
  card.enableFlipping()
deck.mount($container)
});