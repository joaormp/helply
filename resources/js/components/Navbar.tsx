import React, { useState } from 'react';
import { Link } from 'react-router-dom';
import { useLanguage } from '@/contexts/LanguageContext';

interface NavbarProps {
  scrolled: boolean;
}

export default function Navbar({ scrolled }: NavbarProps) {
  const { t, language, setLanguage } = useLanguage();
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);

  return (
    <nav
      className={`fixed top-0 left-0 right-0 z-50 transition-all duration-300 ${
        scrolled
          ? 'bg-white/90 backdrop-blur-lg shadow-lg py-3'
          : 'bg-transparent py-5'
      }`}
    >
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex justify-between items-center">
          {/* Logo */}
          <Link to="/" className="flex items-center space-x-2 group">
            <div className="relative">
              <div className="absolute inset-0 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg blur opacity-25 group-hover:opacity-40 transition-opacity"></div>
              <div className="relative bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-bold text-xl px-4 py-2 rounded-lg transform group-hover:scale-105 transition-transform">
                Helply
              </div>
            </div>
          </Link>

          {/* Desktop Navigation */}
          <div className="hidden lg:flex items-center space-x-8">
            <a
              href="#features"
              className="text-gray-700 hover:text-blue-600 font-medium transition-colors"
            >
              {t.nav.features}
            </a>
            <a
              href="#pricing"
              className="text-gray-700 hover:text-blue-600 font-medium transition-colors"
            >
              {t.nav.pricing}
            </a>
          </div>

          {/* Language Switcher & CTA Buttons */}
          <div className="hidden lg:flex items-center space-x-4">
            <div className="flex items-center space-x-2 bg-gray-100 rounded-lg p-1">
              <button
                onClick={() => setLanguage('pt')}
                className={`px-3 py-1.5 rounded-md text-sm font-medium transition-all ${
                  language === 'pt'
                    ? 'bg-white text-blue-600 shadow-sm'
                    : 'text-gray-600 hover:text-gray-900'
                }`}
              >
                PT
              </button>
              <button
                onClick={() => setLanguage('en')}
                className={`px-3 py-1.5 rounded-md text-sm font-medium transition-all ${
                  language === 'en'
                    ? 'bg-white text-blue-600 shadow-sm'
                    : 'text-gray-600 hover:text-gray-900'
                }`}
              >
                EN
              </button>
            </div>
            <a
              href="/admin/login"
              className="text-gray-700 hover:text-blue-600 font-medium transition-colors"
            >
              {t.nav.login}
            </a>
            <a
              href="/admin/login"
              className="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-6 py-2.5 rounded-lg font-medium hover:from-blue-600 hover:to-indigo-700 transform hover:scale-105 transition-all shadow-lg hover:shadow-xl"
            >
              {t.nav.getStarted}
            </a>
          </div>

          {/* Mobile Menu Button */}
          <button
            onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
            className="lg:hidden text-gray-700 hover:text-blue-600 p-2"
          >
            {mobileMenuOpen ? (
              <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
              </svg>
            ) : (
              <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 6h16M4 12h16M4 18h16" />
              </svg>
            )}
          </button>
        </div>

        {/* Mobile Menu */}
        {mobileMenuOpen && (
          <div className="lg:hidden mt-4 pb-4 border-t border-gray-200 pt-4 space-y-3">
            <a
              href="#features"
              onClick={() => setMobileMenuOpen(false)}
              className="block text-gray-700 hover:text-blue-600 font-medium transition-colors py-2"
            >
              {t.nav.features}
            </a>
            <a
              href="#pricing"
              onClick={() => setMobileMenuOpen(false)}
              className="block text-gray-700 hover:text-blue-600 font-medium transition-colors py-2"
            >
              {t.nav.pricing}
            </a>
            <div className="flex items-center space-x-2 bg-gray-100 rounded-lg p-1">
              <button
                onClick={() => setLanguage('pt')}
                className={`flex-1 px-3 py-2 rounded-md text-sm font-medium transition-all ${
                  language === 'pt'
                    ? 'bg-white text-blue-600 shadow-sm'
                    : 'text-gray-600'
                }`}
              >
                PT
              </button>
              <button
                onClick={() => setLanguage('en')}
                className={`flex-1 px-3 py-2 rounded-md text-sm font-medium transition-all ${
                  language === 'en'
                    ? 'bg-white text-blue-600 shadow-sm'
                    : 'text-gray-600'
                }`}
              >
                EN
              </button>
            </div>
            <a
              href="/admin/login"
              className="block text-gray-700 hover:text-blue-600 font-medium transition-colors py-2"
            >
              {t.nav.login}
            </a>
            <a
              href="/admin/login"
              className="block text-center bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-6 py-3 rounded-lg font-medium hover:from-blue-600 hover:to-indigo-700 shadow-lg"
            >
              {t.nav.getStarted}
            </a>
          </div>
        )}
      </div>
    </nav>
  );
}
