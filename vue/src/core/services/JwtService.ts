const ID_TOKEN_KEY = "id_token" as string;
const MENUS = "menus" as string;
const USER = "user" as string;

/**
 * @description get token form localStorage
 */
export const getToken = (): string | null => {
  return window.localStorage.getItem(ID_TOKEN_KEY);
};

/**
 * @description save token into localStorage
 * @param token: string
 */
export const saveToken = (token: string): void => {
  window.localStorage.setItem(ID_TOKEN_KEY, token);
};

/**
 * @description remove token form localStorage
 */
export const destroyToken = (): void => {
  window.localStorage.removeItem(ID_TOKEN_KEY);
};

/**
 * @description menus form localStorage
 */
export function saveMenus(data: any) {
  localStorage.setItem(MENUS, JSON.stringify(data));
}

export function getMenus() {
  const menus = localStorage.getItem(MENUS);
  return JSON.parse(menus || "{}");
}

/**
 * @description menus form localStorage
 */
export function saveUser(data: any) {
  localStorage.setItem(USER, JSON.stringify(data));
}

export function getUser() {
  const user = localStorage.getItem(USER);
  return JSON.parse(user || "{}");
}

export default { getToken, saveToken, destroyToken, saveMenus, getMenus, saveUser, getUser };
