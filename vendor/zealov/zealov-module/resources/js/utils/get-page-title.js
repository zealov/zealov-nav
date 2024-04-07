export default function getPageTitle(pageTitle,title='后台管理系统') {
  if (pageTitle) {
    return `${pageTitle} - ${title}`
  }
  return `${title}`
}
