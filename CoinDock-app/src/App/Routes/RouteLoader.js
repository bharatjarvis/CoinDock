import { useFetchAuthRefresh } from 'App/Auth/hooks';
import React from 'react';

const RouteLoader = ({children}) => {
  const ready = useFetchAuthRefresh()
  if(!ready){
    return <React.Fragment/>
  }
  return <React.Fragment>{children}</React.Fragment>
}

export default RouteLoader;
