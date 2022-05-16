import { ethers } from 'ethers';
import { Address } from 'cluster';
import { Pool } from '@uniswap/v3-sdk';

const provider = new ethers.providers.JsonRpcProvider('http://99.24.223.153:8547');

const poolAddress = '0x289ba1701C2F088cf0faf8B3705246331cB8A839'; //What is this?

interface Immutables {
  factory: Address
  token0: Address
  token1: Address
  fee: number
  tickSpacing: number
  maxLiquidityPerTick: number
}

const poolImmutablesAbi = [
  'function factory() external view returns (address)',
  'function token0() external view returns (address)',
  'function token1() external view returns (address)',
  'function fee() external view returns (uint24)',
  'function tickSpacing() external view returns (int24)',
  'function maxLiquidityPerTick() external view returns (uint128)',
]

const poolContract = new ethers.Contract(poolAddress, poolImmutablesAbi, provider)

async function getPoolImmutables() {
  const PoolImmutables: Immutables = {
      factory: await poolContract.factory(),
      token0: await poolContract.token0(),
      token1: await poolContract.token1(),
      fee: await poolContract.fee(),
      tickSpacing: await poolContract.tickSpacing(),
      maxLiquidityPerTick: await poolContract.maxLiquidityPerTick(),
  }
  return PoolImmutables
}

getPoolImmutables().then((result) => {
  console.log(result)
})