import React, { createContext, useEffect, useState } from "react";

export const UserContext = createContext();

export const UserContextProvider = ({ children }) => {

  const [user, setUser] = useState(null);
  const [isAuthenticated, setIsAuthenticated] = useState(false);

  useEffect(() => {
    if(user) {
      localStorage.setItem("user", JSON.stringify(user));
    }
    else if(localStorage.getItem("user")) {
      setUser(JSON.parse(localStorage.getItem("user")));
      setIsAuthenticated(true);
    }
  }, [user]);

  const login = (userData, token) => {
    localStorage.setItem("token", token);
    setUser(userData);
    setIsAuthenticated(true);
  };

  const logout = () => {
    localStorage.removeItem("user");
    localStorage.removeItem("token");
    setUser(null);
    setIsAuthenticated(false);
  };

  return <UserContext.Provider value={{ user, isAuthenticated, login, logout }}>{children}</UserContext.Provider>;
};
