import {decodeJwt} from 'jose'

const localStorageAccessToken = process.env.REACT_APP_ACCESS_TOKEN;
const localStorageRefreshToken = process.env.REACT_APP_REFRESH_TOKEN;

export const authToken = () => {
  return localStorage.getItem(localStorageAccessToken)
}
export const refreshToken = () => {
  return localStorage.getItem(localStorageRefreshToken)
}

export const getUserId = () => {
  const {sub} = decodeJwt(authToken())
  return sub
}
