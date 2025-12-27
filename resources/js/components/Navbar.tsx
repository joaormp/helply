import React from 'react';
import { Link } from 'react-router-dom';

interface NavbarProps {
  scrolled: boolean;
}

export default function Navbar({ scrolled }: NavbarProps) {
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
              <div className="absolute inset-0 bg-gradient-to-r from-primary-500 to-indigo-600 rounded-lg blur opacity-25 group-hover:opacity-40 transition-opacity"></div>
              <div className="relative bg-gradient-to-r from-primary-500 to-indigo-600 text-white font-bold text-xl px-4 py-2 rounded-lg transform group-hover:scale-105 transition-transform">
                Helply
              </div>
            </div>
          </Link>

          {/* Desktop Navigation */}
          <div className="hidden md:flex items-center space-x-8">
            <a
              href="#features"
              className="text-gray-700 hover:text-primary-600 font-medium transition-colors"
            >
              Features
            </a>
            <a
              href="#pricing"
              className="text-gray-700 hover:text-primary-600 font-medium transition-colors"
            >
              Pricing
            </a>
            <a
              href="#contact"
              className="text-gray-700 hover:text-primary-600 font-medium transition-colors"
            >
              Contact
            </a>
          </div>

          {/* CTA Buttons */}
          <div className="hidden md:flex items-center space-x-4">
            <a
              href="/admin/login"
              className="text-gray-700 hover:text-primary-600 font-medium transition-colors"
            >
              Sign In
            </a>
            <a
              href="/register"
              className="bg-gradient-to-r from-primary-500 to-indigo-600 text-white px-6 py-2.5 rounded-lg font-medium hover:from-primary-600 hover:to-indigo-700 transform hover:scale-105 transition-all shadow-lg hover:shadow-xl"
            >
              Start Free Trial
            </a>
          </div>

          {/* Mobile Menu Button */}
          <button className="md:hidden text-gray-700 hover:text-primary-600">
            <svg
              className="w-6 h-6"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                strokeLinecap="round"
                strokeLinejoin="round"
                strokeWidth={2}
                d="M4 6h16M4 12h16M4 18h16"
              />
            </svg>
          </button>
        </div>
      </div>
    </nav>
  );
}
