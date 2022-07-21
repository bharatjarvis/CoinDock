import { useEffect, useState } from 'react';
import { useRefresh } from 'App/Api/auth';
import {  refreshToken } from '../helper';
import { useSelector } from 'react-redux';

export const useIsAuthenticated = () => {
  const {token} = useSelector(state => state.auth)
  return Boolean(token)
}

export const useFetchAuthRefresh = () => {
  const [ready, setReady] = useState(false)
  const isAuthenticated = useIsAuthenticated()
  const [refresh] = useRefresh()
  useEffect(() => {
    if(refreshToken() && !isAuthenticated){
      const refreshCall = async () => {
        try{
          await refresh().unwrap()
         }finally{
           setReady(true)
         }
      }
      refreshCall()
    }
    else{
      setReady(true)
    }
  },[refresh, isAuthenticated])
  return ready
}
