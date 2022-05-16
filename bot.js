const ethers = require('ethers');
const secrets =  require('./secrets.json');

const LPT = "";
const WETH = "0x82aF49447D8a07e3bd95BD0d56f35241523fBab1";

const provider = new ethers.providers.WebSocketProvider(secrets.wss);
const wallet = new ethers.Wallet(secrets.privatekey);
const signer = wallet.connect(provider);

const pairContract = new ethers.Contract(
    pair, 
    [
        '',
    ]
)