function data() {
  function getThemeFromLocalStorage() {
    // if user already changed the theme, use it
    if (window.localStorage.getItem('dark')) {
      return JSON.parse(window.localStorage.getItem('dark'))
    }

    // else return their preferences
    return (
      !!window.matchMedia &&
      window.matchMedia('(prefers-color-scheme: dark)').matches
    )
  }

  function setThemeToLocalStorage(value) {
    window.localStorage.setItem('dark', value)
  }

  return {
    dark: getThemeFromLocalStorage(),
    toggleTheme() {
      this.dark = !this.dark
      setThemeToLocalStorage(this.dark)
    },
    isSideMenuOpen: false,
    toggleSideMenu() {
      this.isSideMenuOpen = !this.isSideMenuOpen
    },
    closeSideMenu() {
      this.isSideMenuOpen = false
    },
    isNotificationsMenuOpen: false,
    toggleNotificationsMenu() {
      this.isNotificationsMenuOpen = !this.isNotificationsMenuOpen
    },
    closeNotificationsMenu() {
      this.isNotificationsMenuOpen = false
    },
    isProfileMenuOpen: false,
    toggleProfileMenu() {
      this.isProfileMenuOpen = !this.isProfileMenuOpen
    },
    closeProfileMenu() {
      this.isProfileMenuOpen = false
    },
    isLotsMenuOpen: false,
    toggleLotsMenu() {
      this.isLotsMenuOpen = !this.isLotsMenuOpen
    },
    isDossiersMenuOpen: false,
    toggleDossiersMenu() {
      this.isDossiersMenuOpen = !this.isDossiersMenuOpen
    },
    isPaiementsMenuOpen: false,
    togglePaiementsMenu() {
      this.isPaiementsMenuOpen = !this.isPaiementsMenuOpen
    },
    isAmenagementMenuOpen: false,
    toggleAmenagementMenu() {
      this.isAmenagementMenuOpen = !this.isAmenagementMenuOpen
    },   
    isVisitesMenuOpen: false,
    toggleVisitesMenu() {
      this.isVisitesMenuOpen = !this.isVisitesMenuOpen
    },   
    isAppartementsMenuOpen: false,
    toggleAppartementsMenu() {
      this.isAppartementsMenuOpen = !this.isAppartementsMenuOpen
    },    
    isMagasinsMenuOpen: false,
    toggleMagasinsMenu() {
      this.isMagasinsMenuOpen = !this.isMagasinsMenuOpen
    },   
    isBureauxMenuOpen: false,
    toggleBureauxMenu() {
      this.isBureauxMenuOpen = !this.isBureauxMenuOpen
    },           
    isPagesMenuOpen: false,
    togglePagesMenu() {
      this.isPagesMenuOpen = !this.isPagesMenuOpen
    },               
    // Modal
    isModalOpen: false,
    trapCleanup: null,
    openModal() {
      this.isModalOpen = true
      this.trapCleanup = focusTrap(document.querySelector('#modal'))
    },
    closeModal() {
      this.isModalOpen = false
      this.trapCleanup()
    },
  }
}
